<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<?php
include 'newNav.php';

?>
  
  <h1> Admin Mode</h1>

<?php
if(isset($_POST['logout'])){
     unset($_SESSION['logged_user']);
     //echo "You are now logged out";
  }
if(isset($_SESSION['logged_user'])){

?>
<h2>Click this button to logout</h2>
<form action= "login.php" method= "post">
<input type = "submit" value = "Log Out" name = "logout">
</form>
<?php
 
}else{  
?>

  <h2>Log In</h2>
  <form action = "login.php" method = "post">
    
  <h3>Username:</h3><input type= "text" name="username"> <br>
  
  <h3>Password:</h3><input type= "password" name="password"> <br>
  
  <input type= "submit" value="Log In" name= "button">
  </form>
<?php
//everything is empty
}
?>
<?php
if(isset($_POST['button'])){
//when username and password are set but session hasnt started
    $post_username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
    $post_password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
    require_once 'config.php';
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    $hashed_password = hash("sha256",$post_password);
    
    $query = "SELECT * FROM users WHERE username = '$post_username' AND password ='$hashed_password'";
        
    $result = $mysqli->query($query);
   // $test1 = $mysqli->query($test);
    if($result && $result->num_rows == 1){
      $row = $result->fetch_assoc();
      $db_username = $row['username'];
        
      print("<p>Congrats, $db_username. You are now an admin</p>");
        
      $_SESSION['logged_user'] = $db_username;
    }else{
      print("<p>wrong password, please try again</p>");
    }
} 
?>

</body>
</html>