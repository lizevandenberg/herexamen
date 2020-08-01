<?php

include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';
session_start();

	$user=$_SESSION['user'];
	$userid = $user->getuserid();
	$username = $user->getusername();
	


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Virtual Currency App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
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
<div>
    <h4>Welkom <?php echo("Welkom $username"); ?></h4>
</div>
<a href="logout.php">Log out</a>
</div>
</main>
</div>

</body>
</html>
