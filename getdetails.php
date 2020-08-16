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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Currency App</title>
    <link rel="stylesheet" href="/herexamen/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
<div id="menu" >
<img id="logo2" src="/herexamen/img/logo-8.png" alt="logo">
<a id="myButton4" href="home.php">Terug</a>
<div id="label"><label id="currentbalance" name="currentbalance"><?php echo("$balance"); ?></label><label id="currentbalance1" >&nbsptokens op uw rekening</label></div>
<p>&nbspu heeft&nbsp</p>
<h2>Welkom <?php echo("$username"); ?></h2>
</div>
<div id="overzicht">
<div id="topmenu">
<h1>Details van transfer</h1>
</div>
<div id="ondermenu">
<?php
echo("<label id='form5'>  $sender</label><br/>"); 
echo("<label id='form5'>  $receiver</label><br/>"); 
echo("<label id='form5'>  $amount</label><br/>"); 
echo("<label id='form5'>  $comment</label><br/>"); 
echo("<label id='form5'>  $timestamp</label><br/>"); 
?>
</div>
</div>



</body>
</html>