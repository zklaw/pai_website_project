<?php

require_once "config.php";

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM tickets WHERE ticket_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $ticket_name = $row["ticket_name"];
                $ticket_price = $row["ticket_price"];
				$ticket_description = $row["ticket_description"];
				$ticket_img = $row["ticket_img"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<?php 
	include "head.php";
?>
<body>
    <div class="parallax full-height">		
	<div class="row pt-5 align-items-center">
		<div class="col-10 offset-1 col-lg-8 offset-lg-2 login-form">
                    <div class="page-header">
                        <h2>View Record</h2>
                    </div>
                    <div class="form-group">
                        <label><strong>Name</strong></label>
                        <p class="form-control-static"><?php echo $row["ticket_name"]; ?></p>
                    </div>
			
                    <div class="form-group">
                        <label><strong>Price $</strong></label>
                        <p class="form-control-static"><?php echo $row["ticket_price"]; ?></p>
                    </div>

					<div class="form-group">
                        <label><strong>Description</strong></label>
                        <p class="form-control-static"><?php echo $row["ticket_description"]; ?></p>
                    </div>
			
					<div class="form-group">
                        <label><strong>Image path</strong></label>
                        <p class="form-control-static"><?php echo $row["ticket_img"]; ?></p>
                    </div>
			
                    <p><a href="welcome_admin.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
   
</body>
</html>