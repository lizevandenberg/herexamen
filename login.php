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
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>

<div id="kader">
<?php
    if(isset($_SESSION['message']))
    {
         echo "<div id='error_msg'>".$_SESSION['message']."</div>";
         unset($_SESSION['message']);
    }
?>
<img id="profiel" src="img/foto-8.png" alt="logo">
<form method="post" action="login.php">
  <table>
     <tr>
           <td><input id="form2" type="text" placeholder="Gebruikersnaam" name="username" class="textInput"></td>
     </tr>
      <tr>
           <td><input id="form2" type="password" placeholder="Wachtwoord" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td><input id="myButton3" type="submit" name="login_btn" class="Log In"></td>
     </tr>
 
</table>
</form>
</div>

</body>
</html>
