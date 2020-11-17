<?php

include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';
include 'transaction.php';
session_start();
	$user = new User();
	$userid = $user->getuserid();
	$username = $user->getusername();
	$tran = new Transaction();
	$transactionlist = $tran->getTransactionOverview($userid);	
	$balance = $tran->getbalance($userid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Virtual Currency App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/jquery-ui.js"></script>
  	<style>
	.typeahead { background-color: #FFFFFF ;
   color: #C6C3BD;
   border-color:#C6C3BD ;
   box-shadow: none;
   font-family: 'Proxima Nova', sans-serif;;
   width: 240px;
   height: 40px;
   border-radius: 12.5px;
   font-size: 17px;
   margin-left: 70px;
   margin-top: 5px;
   text-align: center;}
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#FFF;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.bgcolor {max-width: 550px;min-width: 290px;max-height:340px;background:url("world-contries.jpg") no-repeat center center;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#FFF;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #1f3f41;
    outline: 0;
    
    
	}
	</style>	
  <?php
  if(isset($_SESSION['errormsg'])AND !is_null($_SESSION['errormsg'])){
	$errortoshow = $_SESSION['errormsg'];
	echo '<script language="javascript">';
	echo "alert('$errortoshow')";
    echo '</script>';};
    unset($_SESSION['errormsg']);
	?>
</head>
<body>
  
<div id="menu" >
<img id="logo2" src="img/logo-8.png" alt="logo">
<a id="myButton4" href="logout.php">Log out</a>
<div id="label"><label id="currentbalance" name="currentbalance"><?php echo("$balance"); ?></label><label id="currentbalance1" >&nbsptokens op uw rekening</label></div>
<p>&nbspu heeft&nbsp</p>
<h2>Welkom <?php echo("$username"); ?></h2>

</div>

<div id="overzicht">
<div id="topmenu">
<h1>Overzicht</h1>
</div>
<div id="ondermenu">
<?php
$transactions = json_decode($transactionlist);
echo '<ul id="transactions">';
foreach($transactions as $i => $item) {
$row = json_decode($item,True);
$string = $row['transactioninfo'];
$id = $row['transactionId'];
echo("<li id='$id' >$string </li>");
}
echo '</ul>';
?>
</div>
</div>

<div id="overzicht">
<div id="topmenu1">
<h1>Transfer</h1>
</div>
<div id="ondermenu1">
<form action="executetransfer.php" method="post">
	<input type="text" placeholder="Gebruiker" name="userlookup" id="userlookup" class="typeahead"/><br>
	<input id="form4" type="text" placeholder="Bedrag" name="amount" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="amount" /><br>
	<input id="form4" type="text" placeholder="Mededeling" name="comment" id="comment" /><br>
	<input id="myButton5" type="submit" value="Submit">
	</form>
</div>
</div>

</body>
<script>
    $(document).ready(function () {
        $('#userlookup').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "typeahead.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						console.log(data);
						result($.map(data, function (item) {
							return item.firstname.concat(" ",item.lastname);
                        }));
                    }
                });
            },minLength: 2,
        });
    });
</script>
<script>
const label = document.getElementById('currentbalance'); 
const balanceurl = 'checkbalance.php'; 
const transactionurl = 'checknewtransactions.php';
var ul = document.getElementById('transactions');

 (function loop() {
  setTimeout(function () {
	  fetch(balanceurl).then((response) => {
    console.log(response);
    response.json().then((data) => {
        console.log(data);
		label.innerHTML=data;
    });
});
    loop();}, 10000);
}());

ul.addEventListener('click', function(e) {
    if (e.target.tagName === 'LI'){	  
		window.location.href = "getdetails.php/?query="+e.target.id;	
    }
});
</script>
</html>
