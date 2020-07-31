<?php
session_start();

//connect to database
$db=mysqli_connect("localhost","root","root","mysite");
$PostfixWhitelist = "@student.thomasmore.be";
if(isset($_POST['register_btn']))
{
    $username=mysqli_real_escape_string($db,$_POST['username']);
    $email=mysqli_real_escape_string($db,$_POST['email']);
    $firstname=mysqli_real_escape_string($db,$_POST['voornaam']);
    $lastname=mysqli_real_escape_string($db,$_POST['achternaam']);
    if (substr($email, -22) != $PostfixWhitelist){
        echo '<script language="javascript">';
		echo 'alert("Only valid TMM emails allowed ")';
        echo '</script>';
    }
	else
	{
    $password=mysqli_real_escape_string($db,$_POST['password']);
    $password2=mysqli_real_escape_string($db,$_POST['password2']);  
    $query = "SELECT 1 FROM users WHERE username = '$username' OR email = '$email'";
    
    $result=mysqli_query($db,$query);
      if($result)
      {
     
        if( mysqli_num_rows($result) > 0)
        {
                
                echo '<script language="javascript">';
                echo 'alert("Username or Email already exists")';
                echo '</script>';
        }
        
          else
          {
            
            if(($password==$password2) and (strlen($password) > 4))
            {   //Create User
                $password=md5($password); //hash password before storing for security purposes
                $sql="INSERT INTO users(username, email, password, firstname, lastname ) VALUES('$username','$email','$password','$firstname','$lastname')"; 
                mysqli_query($db,$sql);  
				$kaching="INSERT INTO transactions(sender, receiver,amount,comment) SELECT  0, userid, 10, 'Welkom bij de Kaching familie!' FROM userlookup WHERE voornaam='$firstname' AND achternaam='$lastname'";
                mysqli_query($db,$kaching); 
                $_SESSION['username']=$username;
                header("location:home.php");  //redirect home page
            }
            else
            {
                $_SESSION['message']="De wachtwoorden komen niet overeen of zijn niet lang genoeg.";   
            }
          }
	}}
      

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
  <link rel="stylesheet" href="css/style.css">
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
<form method="post" action="register.php">
  <table>
     <tr>
           <td><input type="text" value="Gebruikersnaam" name="username" class="textInput"></td>
     </tr>
     <tr>
           <td><input type="email" value="Email" name="email" class="textInput"></td>
     </tr>
     <tr>
           <td><input type="text" value="Voornaam" name="voornaam" class="textInput"></td>
     </tr>
     <tr>
           <td><input type="text" value="Achternaam" name="achternaam" class="textInput"></td>
     </tr>
      <tr>
           <td><input type="password" value="Wachtwoord" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td><input type="password" value="Wachtwoord bevestigen" name="password2"class="textInput"></td>
     </tr>
      <button id="myButton3" class="float-left submit-button"> Log in</button>
    </table>

</form>
</div>

<script type="text/javascript">
    document.getElementById("myButton3").onclick = function () {
        location.href = "home.php";
    };
</script>
</body>
</html>




