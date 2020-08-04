<?php

include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';
include 'transaction.php';
session_start();

	$user=$_SESSION['user'];
	$userid = $user->getuserid();
	$username = $user->getusername();
	$tran = new Transaction();
	$_SESSION['tran']=$tran;
	$transactionlist = $tran->getTransactionOverview($userid);	
	$balance = $tran->getbalance($userid);	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Virtual Currency App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/jquery-ui.js"></script>
  	<style>
	.typeahead { border: 2px solid #FFF;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;background: rgba(66, 52, 52, 0.5);color: #FFF;}
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
  
</head>
<body>

<div class="container">

<br>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
  <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav center">
        <li><a href="login.php">Log in</a></li>
        <li><a href="register.php">registeer</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>

    </div>
  </div>
</nav>


<main class="main-content">
 <div class="col-md-6 col-md-offset-4">
<h1>Home</h1>
<label id="currentbalance" name="currentbalance"><?php echo("$balance"); ?></label>
<div>
<?php
$transactions = json_decode($transactionlist);
echo '<ul id="transactions">';
foreach($transactions as $i => $item) {
$row = json_decode($item,True);
$string = $row['transactioninfo'];
$id = $row['transactionId'];
echo("<li id='$id' >$string </li>");
}
echo '</ul>';?>
	<label class="demo-label">Search users:HALLLLLLLLLLLLLLLLLLLLLLLLLLLLLOOOOOOOOOOOOOOOOOO</label><br/> 
	<input type="text" name="userlookup" id="userlookup" class="typeahead"/>
	
</div>
<a href="logout.php">Log out</a>
</div>
</main>
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
const label = document.getElementById('currentbalance'); // Get the list where we will place our authors
const url = 'checkbalance.php'; // Get 10 random users


 (function loop() {
  setTimeout(function () {
	  fetch(url).then((response) => {
    console.log(response);
    response.json().then((data) => {
        console.log(data);
		label.innerHTML=data;
    });
});
    loop();}, 9000);
}());

var ul = document.getElementById('transactions');  // Parent

ul.addEventListener('click', function(e) {
    if (e.target.tagName === 'LI'){  // Check if the element is a LI
    }
});



</script>
</html>
