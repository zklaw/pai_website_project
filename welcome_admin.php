<?php
require_once "config.php";

// Initialize the session
if ( session_status() == PHP_SESSION_NONE ) {
	//session has not started
	session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if ( !isset( $_SESSION[ "loggedin" ] ) || $_SESSION[ "loggedin" ] !== true || $_SESSION[ "username" ] != $admin_name) {
	header( "location: login_admin.php" );
	$_SESSION = array();
	$admin_log = false;

	// Destroy the session.
	session_destroy();

	// Redirect to login page
	header("location: index.php");
	exit;

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
				<a href="reset-password_admin.php" class="btn btn-primary mt-1">Reset Your Password</a>
				<a href="logout.php" class="btn btn-primary mt-1">Sign Out of Your Account</a>
			</p>
		</div>
	</div>
		
	<div class="row pt-5 align-items-center">
		<div class="col-10 offset-1 col-lg-8 offset-lg-2 login-form">
			
			<div class="page-header clearfix">
				<h2 class="float-left">Tickets Details</h2>
				<a href="create.php" class="btn btn-primary float-right">Add New Ticket</a>
			</div>
			
	<?php 
		$sql = "SELECT * FROM tickets";
		if($result = mysqli_query($link, $sql)){
			if(mysqli_num_rows($result) > 0){
				echo "<table class='table table-bordered table-striped'>";
					echo "<thead>";
						echo "<tr>";
							echo "<th>#</th>";
							echo "<th>Name</th>";
							echo "<th>$</th>";
							echo "<th>Description</th>";
							echo "<th>Img path</th>";
							echo "<th>Action</th>";
						echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					while($row = mysqli_fetch_array($result)){
						echo "<tr>";
							echo "<td>" . $row['ticket_id'] . "</td>";
							echo "<td>" . $row['ticket_name'] . "</td>";
							echo "<td>" . $row['ticket_price'] . "</td>";
							echo "<td>" . $row['ticket_description'] . "</td>";
							echo "<td>" . $row['ticket_img'] . "</td>";
							echo "<td>";
								echo "<a href='read.php?id=". $row['ticket_id'] ."' title='View Record' data-toggle='tooltip'><span>read </span></a>";
								echo "<a href='update.php?id=". $row['ticket_id'] ."' title='Update Record' data-toggle='tooltip'><span>edit </span></a>";
								echo "<a href='delete.php?id=". $row['ticket_id'] ."' title='Delete Record' data-toggle='tooltip'><span>delete </span></a>";
							echo "</td>";
						echo "</tr>";
					}
					echo "</tbody>";                            
				echo "</table>";
				// Free result set
				mysqli_free_result($result);
			} else{
				echo "<p class='lead'><em>No records were found.</em></p>";
			}
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
	?>
		</div>
		</div>
		
</body>
</html>