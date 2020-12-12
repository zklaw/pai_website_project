<?php
require_once "config.php";

// Initialize the session
if ( session_status() == PHP_SESSION_NONE ) {
	//session has not started
	session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if ( !isset( $_SESSION[ "loggedin" ] ) || $_SESSION[ "loggedin" ] !== true ) {
	header( "location: login.php" );

}
?>

<!DOCTYPE html>
<html>
<?php
include "head.php";
?>

<body>
	<?php 
	include 'navigation.php'
	?>
	<div class="parallax full-height">
		
	<div class="row pt-5 align-items-center">
		<div class="col-10 offset-1 col-lg-8 offset-lg-2 login-form">
			<div class="page-header">
				<h5 class="text-center text-uppercase">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to your profile.</h5>
			</div>
			<p class="text-center">
				<a href="reset-password.php" class="btn btn-primary mt-1">Reset Your Password</a>
				<a href="logout.php" class="btn btn-primary mt-1">Sign Out of Your Account</a>
			</p>
		</div>
	</div>
		
	<div class="row py-1">
		<div class="col-lg-8 offset-lg-2 col-10 offset-1 login-form">
			<h5 class="text-uppercase text-center">Your tickets</h5>
			
				
				<?php
				$tickets_user_sql = 'SELECT `ticket_user_id`,`ticket_id` 
						FROM `tickets_users`
						WHERE user_id=?';
				if ( $tickets_user_stmt = mysqli_prepare( $link, $tickets_user_sql ) ) {
					mysqli_stmt_bind_param( $tickets_user_stmt, "i", $param_user );
					$param_user = $_SESSION[ "id" ];

					if ( mysqli_stmt_execute( $tickets_user_stmt ) ) {
						$tickets_user_result = $tickets_user_stmt->get_result();

						if ( mysqli_num_rows( $tickets_user_result ) > 0 ) {
							echo '<div class="card-group text-center">';
							while ( $tickets_user_row = $tickets_user_result->fetch_assoc() ) {

								$ticket_sql = 'SELECT `ticket_id`, `ticket_name`, `ticket_description`, `ticket_price`, `ticket_img` 
										FROM `tickets`
										WHERE `ticket_id`=?';
								if ( $ticket_stmt = mysqli_prepare( $link, $ticket_sql ) ) {
									mysqli_stmt_bind_param( $ticket_stmt, "i", $param_ticket );

									$param_ticket = $tickets_user_row[ 'ticket_id' ];


									if ( mysqli_stmt_execute( $ticket_stmt ) ) {

										$ticket_result = $ticket_stmt->get_result();
										if ( mysqli_num_rows( $ticket_result ) > 0 ) {
											$ticket_row = $ticket_result->fetch_assoc();
											echo '<div class="card" >
													<img class="card-img-top" src="' . $ticket_row[ 'ticket_img' ] . '" alt="' . $ticket_row[ 'ticket_name' ] . ' img">
													<div class="card-body">
														<h5 class="card-title text-uppercase">' . $ticket_row[ 'ticket_name' ] . '</h5>
														<p class="card-text">' . $ticket_row[ 'ticket_description' ] . '</p>
														<a href="delete_ticket.php?id=' . $tickets_user_row[ 'ticket_user_id' ] . '" class="btn btn-primary">Delete</a>
													</div>
												  </div>';
										}
									}
								}
							}
							echo '</div>';
						}else {
							echo '<p class="text-center text-uppercase">you have no tickets</p>';
						}	 
					}
					mysqli_stmt_close( $tickets_user_stmt );
				}


				?>
				
			</div>
		</div>		
	</div>
</body>
</html>