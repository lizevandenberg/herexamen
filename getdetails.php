<?php	
include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';
include 'transaction.php';

session_start();	
	$transactionId = $_GET['query'];
	$user = new User();
	$userid = $user->getuserid();
	$user->breakDBConnection();	
	$tran = new Transaction();
	$results = $tran->getTransactiondetails($transactionId);	
	$result = json_decode($results, True);
	$sender = $result['sender'];
	$receiver = $result['receiver'];
	$comment = $result['comment'];
	$amount = $result['amount'];
	$timestamp = $result['timestamp'];
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
<?php
echo("<label>  $sender</label><br/>"); 
echo("<label>  $receiver</label><br/>"); 
echo("<label>  $amount</label><br/>"); 
echo("<label>  $comment</label><br/>"); 
echo("<label>  $timestamp</label><br/>"); 
?>
</body>