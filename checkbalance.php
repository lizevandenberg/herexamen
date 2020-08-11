<?php	
include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';
include 'transaction.php';

session_start();	
	$user = new User();
	$tran = new Transaction();
	$userid = $user->getuserid();
	$user->breakDBConnection();	
	$results = $tran->getbalance($userid);	
	echo $results;
?>