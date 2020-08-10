<?php	
include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';

session_start();	
	if(isset($_POST['query'])){
	$user = new User();
	$user->wakeupDBConnection();
	$results = $user->lookupUser($_POST['query']);
	echo $results;
	}
?>

