<?php

include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';

session_start();
if(isset($_SESSION['username'])){
  header("location:home.php");
  die();
}
  if(isset($_POST['login_btn']))
  {
  if(isset($_SESSION['errormsg'])AND !is_null($_SESSION['errormsg'])){
	$errortoshow = $_SESSION['errormsg'];
	echo '<script language="javascript">';
	echo "alert('$errortoshow')";
	echo '</script>';};
	
	  $username=$_POST['username'];
	  echo($username);
      $password=$_POST['password'];
	  $conn = new UserManagement();
      $result = $conn->Login($username,$password);
  }
  
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
</head>
<body>
<div id="kader">
<img id="profiel" src="img/foto-8.png" alt="">
<form method="post" action="login.php">
  <table>
     <tr>
           <td><input id="form2" type="text" placeholder="Gebruikersnaam" name="username" class="textInput"></td>
     </tr>
      <tr>
           <td><input id="form3" type="password" placeholder="Wachtwoord" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td><input id="myButton3" type="submit" name="login_btn" class="Register"></td>
     </tr>
 
</table>
</form>
</div>
</body>
</html>
