<?php

require_once "config.php"; 

$id = $_GET['id']; // get id through query string

$del = mysqli_query($link,"delete from tickets_users where ticket_user_id = '$id'"); // delete query

if($del)
{
    mysqli_close($link); // Close connection
    header("location:welcome_user.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>