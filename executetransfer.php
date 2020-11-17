<?php	
include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';
include 'transaction.php';

session_start();	
	$recipient = $_POST['userlookup'];
	$amount = $_POST['amount'];
	$comment = $_POST['comment'];
	
	$user = new User();
	$tran = new Transaction();
	$userid = $user->getuserid();
	$recipientuserid = $user->getuserid($recipient);
	$user->breakDBConnection();	
	$availablefunds = $tran->getbalance($userid);	
	
	if($amount<($availablefunds+1)){
		$response = $tran->createTransaction($userid, $recipientuserid, $amount, $comment);
	if($response==True){
		header("location:home.php");
	}}
	else{
		$_SESSION['errormsg']="niet genoeg tokens op je rekening";
		header("location:home.php");
	};
?>