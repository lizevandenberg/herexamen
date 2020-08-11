<?php

include 'mysqldb.php';
include 'usermanagement.php';
session_start();

$PostfixWhitelist = "@student.thomasmore.be";
if (isset($_POST['register_btn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $firstname = $_POST['voornaam'];
    $lastname = $_POST['achternaam'];
    if (substr($email, -22) != $PostfixWhitelist)
    {
        echo '<script language="javascript">';
        echo 'alert("Only valid TMM emails allowed ")';
        echo '</script>';
    }
    else
    {
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
		$conn = new Usermanagement();
        $result = $conn->CheckDuplicateUser($username,$email);
        if ($result['flag'] == 1)
        {
            echo '<script language="javascript">';
            echo 'alert("Username or Email already exists")';
            echo '</script>';
        }

        else
        {

            if (($password == $password2) and (strlen($password) > 4))
            { //Create User
				$conn->RegisterNewUser($username,$email, $password,$firstname,$lastname);
				$conn->InitialWalletFill($firstname,$lastname);
                $_SESSION['username'] = $username;
                header("location:home.php"); //redirect home page
                
            }
            else
            {
				echo '<script language="javascript">';
			    echo 'alert("De wachtwoorden komen niet overeen of zijn niet lang genoeg.")';
			    echo '</script>';
            }
        }
    }

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
<form method="post" action="register.php">
  <table>
     <tr>
           <td><input id="form" type="text" placeholder="Gebruikersaam" name="username" class="textInput"></td>
     </tr>
     <tr>
           <td><input id="form" type="email" placeholder="Email" name="email" class="textInput"></td>
     </tr>
     <tr>
           <td><input id="form" type="text" placeholder="Voornaam" name="voornaam" class="textInput"></td>
     </tr>
     <tr>
           <td><input id="form" type="text" placeholder="achternaam" name="achternaam" class="textInput"></td>
     </tr>
      <tr>
           <td><input id="form" type="password" placeholder="Wachtwoord" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td><input id="form" type="password" placeholder="Wachtwoord bevestigen" name="password2"class="textInput"></td>
     </tr>
      <tr>
           <td><input  id="myButton3" type="submit" name="register_btn" class="Register"></td>
     </tr>
    </table>

</form>
</div>
</body>
</html>




