<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$ticket_name = $ticket_price = $ticket_description = $ticket_img = "";
$ticket_name_err = $ticket_price_err = $ticket_description_err = $ticket_img_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
   $ticket_input_name = trim($_POST["ticket_name"]);
    if(empty($ticket_input_name)){
        $ticket_name_err = "Please enter a ticket name.";
    } else{
        $ticket_name = $ticket_input_name;
    }
	
    $ticket_input_price = trim($_POST["ticket_price"]);
    if(empty($ticket_input_price)){
        $ticket_price_err = "Please enter a ticket price.";
    } else{
        $ticket_price = $ticket_input_price;
    }

	$ticket_input_description = trim($_POST["ticket_description"]);
    if(empty($ticket_input_description)){
        $ticket_description_err = "Please enter a ticket description.";
    } else{
        $ticket_description = $ticket_input_description;
    }
	
	$ticket_input_img = trim($_POST["ticket_img"]);
    if(empty($ticket_input_img)){
        $ticket_img_err = "Please enter a ticket img path.";
    } else{
        $ticket_img = $ticket_input_img;
    }
    
    
    // Check input errors before inserting in database
    if(empty($ticket_name_err) && empty($ticket_price_err) && empty($ticket_description_err) && empty($ticket_img_err)){
        // Prepare an update statement
        $sql = "UPDATE tickets SET ticket_name=?, ticket_price=?, ticket_description=?, ticket_img=? WHERE ticket_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sissi", $param_ticket_name, $param_ticket_price, $param_ticket_description, $param_ticket_img, $param_id);
            
            // Set parameters
            $param_ticket_name = $ticket_name;
			$param_ticket_price = $ticket_price;
			$param_ticket_description = $ticket_description;
			$param_ticket_img = $ticket_img;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: welcome_admin.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM tickets WHERE ticket_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $ticket_name = $row["ticket_name"];
                    $ticket_price = $row["ticket_price"];
					$ticket_description = $row["ticket_description"];
					$ticket_img = $row["ticket_img"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($ticket_name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="ticket_name" class="form-control" value="<?php echo $ticket_name; ?>">
                            <span class="help-block"><?php echo $ticket_name_err;?></span>
                        </div>
						
						<div class="form-group <?php echo (!empty($ticket_price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="number" name="ticket_price" class="form-control" value="<?php echo $ticket_price; ?>">
                            <span class="help-block"><?php echo $ticket_price_err;?></span>
                        </div>
						
                        <div class="form-group <?php echo (!empty($ticket_description_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                            <textarea name="ticket_description" class="form-control"><?php echo $ticket_description; ?></textarea>
                            <span class="help-block"><?php echo $ticket_description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ticket_img_err)) ? 'has-error' : ''; ?>">
                            <label>Image path</label>
                            <input type="text" name="ticket_img" class="form-control" value="<?php echo $ticket_img; ?>">
                            <span class="help-block"><?php echo $ticket_img_err;?></span>
                        </div>
						
						
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="welcome_admin.php" class="btn btn-primary">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>

</body>
</html>