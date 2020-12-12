<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$ticket_name = $ticket_price = $ticket_description = $ticket_img = "";
$ticket_name_err = $ticket_price_err = $ticket_description_err = $ticket_img_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
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
        // Prepare an insert statement
        $sql = "INSERT INTO tickets (ticket_name, ticket_price, ticket_description, ticket_img) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siss", $param_ticket_name, $param_ticket_price, $param_ticket_description, $param_ticket_img);
            
            // Set parameters
            $param_ticket_name = $ticket_name;
			$param_ticket_price = $ticket_price;
			$param_ticket_description = $ticket_description;
			$param_ticket_img = $ticket_img;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html >
<?php
	include "head.php";
?>
<body>
   <div class="parallax full-height">		
	<div class="row pt-5 align-items-center">
		<div class="col-10 offset-1 col-lg-8 offset-lg-2 login-form">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="welcome_admin.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
  
</body>
</html>