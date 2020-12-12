<?php


require_once "config.php";

// Initialize the session
if(session_status() == PHP_SESSION_NONE){
				//session has not started
	session_start();
}
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
	
}
if($_SESSION['username']==$admin_name){
	header("location: welcome_admin.php");
}else{




$ticket_id = $_GET['id']; // get id through query string



$sql = 'INSERT INTO `tickets_users`(`user_id`, `ticket_id`)
		VALUES (?, ?)';

if($add_stmt = mysqli_prepare($link, $sql)){
	mysqli_stmt_bind_param($add_stmt, "ii", $param_user_id, $param_ticket_id);
	$param_user_id = $_SESSION["id"];
	$param_ticket_id = $ticket_id;
	mysqli_stmt_execute($add_stmt);
	mysqli_stmt_close($add_stmt);
	header("location: welcome_user.php");
}
else{
	echo 'error adding record';
}
}