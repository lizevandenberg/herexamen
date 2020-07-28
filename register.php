<?php
session_start();

//connect to database
$db=mysqli_connect("localhost","root","root","mysite");
$PostfixWhitelist = "@student.thomasmore.be";
if(isset($_POST['register_btn']))
{
    $username=mysqli_real_escape_string($db,$_POST['username']);
    $email=mysqli_real_escape_string($db,$_POST['email']);
    if (!(substr($email, -22) == $PostfixWhitelist)){
      header("location:register.php");
    }
    $password=mysqli_real_escape_string($db,$_POST['password']);
    $password2=mysqli_real_escape_string($db,$_POST['password2']);  
    $query = "SELECT 1 FROM users WHERE username = '$username'";
    
    $result=mysqli_query($db,$query);
      if($result)
      {
     
        if( mysqli_num_rows($result) > 0)
        {
                
                echo '<script language="javascript">';
                echo 'alert("Username already exists")';
                echo '</script>';
        }
        
          else
          {
            
            if(($password==$password2) and (!strlen($password) < 5))
            {           //Create User
                $password=md5($password); //hash password before storing for security purposes
                $sql="INSERT INTO users(username, email, password ) VALUES('$username','$email','$password')"; 
                mysqli_query($db,$sql);  
                $_SESSION['username']=$username;
                header("location:home.php");  //redirect home page
            }
            else
            {
                $_SESSION['message']="De wachtwoorden komen niet overeen of zijn niet lang genoeg.";   
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
           <td>Gebruikersnaam: </td>
           <td><input type="text" name="username" class="textInput"></td>
     </tr>
     <tr>
           <td>Email: </td>
           <td><input type="email" name="email" class="textInput"></td>
     </tr>
      <tr>
           <td>Paswoord: </td>
           <td style="visibility:
           <?php 
           if(isset($_POST['password'])){
            
              echo "visible;\"> je wachtwoorden komen niet overeen of zijn te kort <tr></tr>";
           }
           else{
            echo "collapse;\"> <tr></tr>";
           }
           ?>

           <td><input type="password" name="password" class="textInput"></td>
     </tr>
      <tr>
           <td>Paswoord bevestigen: </td>
           <td><input type="password" name="password2"class="textInput"></td>
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




