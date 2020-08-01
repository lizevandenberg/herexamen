<?php

include 'mysqldb.php';
include 'usermanagement.php';
include 'user.php';

session_start();
if(  isset($_SESSION['username']) )
{
  header("location:home.php");
  die();
}
  if(isset($_POST['login_btn']))
  {
	  $username=$_POST['username'];
	  echo($username);
      $password=$_POST['password'];
	  $password = md5($password);
{	  $conn = new UserManagement();
      $result = $conn->Login($username,$password);
      if($result['flag'] == 1)
      {
            $_SESSION['message']="Je bent ingelogd";
            $_SESSION['username']=$username;
			$user = new User($username);
			$_SESSION['user']=$user;
            header("location:home.php");
        }
       else
       {
              	echo '<script language="javascript">';
			    echo 'alert("Wachtwoord onjuist of de gebruiker bestaat niet.")';
			    echo '</script>';
       }
  }}
  
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
        <li><a href="register.php">Registreer</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>

    </div>
  </div>
</nav>

<main class="main-content">
<div class="col-md-6 col-md-offset-2">
<form method="post" action="login.php">
  <table>
     <tr>
           <td>Gebruikersnaam: </td>
           <td><input type="text" name="username" class="textInput"></td>
     </tr>
      <tr>
           <td>Wachtwoord: </td>
           <td><input type="password" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td></td>
           <td><input type="submit" name="login_btn" class="Log In"></td>
     </tr>
 
</table>
</form>
</div>

</main>
</div>

</body>
</html>
