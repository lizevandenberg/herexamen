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
        <li><a href="register.php">Registeer</a></li>
      </ul>

    </div>
  </div>
</nav>


<main class="main-content">
<div class="col-md-6 col-md-offset-2">
<form method="post" action="register.php">
  <table>
     <tr>
           <td>Gebruikersnaam: </td>
           <td><input type="text" name="username" class="textInput"></td>
     </tr>
     <tr>
           <td>Email: </td>
           <td><input type="email" name="email" class="textInput"></td>
     </tr>
     <tr>
           <td>Voornaam: </td>
           <td><input type="text" name="voornaam" class="textInput"></td>
     </tr>
     <tr>
           <td>Achternaam: </td>
           <td><input type="text" name="achternaam" class="textInput"></td>
     </tr>
      <tr>
           <td>Paswoord: </td>
           <td><input type="text" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td>Paswoord bevestigen: </td>
           <td><input type="text" name="password2"class="textInput"></td>
     </tr>
      <tr>
           <td></td>
           <td><input type="submit" name="register_btn" class="Register"></td>
     </tr>
    </table>

</form>
</div>

</main>
</div>

</body>
</html>




