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
<?php
if(isset($_SESSION['logged_user'])){

?>
  <div id ="center2">
  <h1>Choose to Edit Albums or Photos</h1> 
  </div>
  <div id = "page">   
    <form action="editAlbum.php">
      <input type="submit" value="Edit Albums">
    </form>
    <form action="edit.php">
      <input type="submit" value="Edit Photos">
    </form>
  </div>

<?php
}else{
  print("<div class = 'adminMsg'>");
    print("<p>You cannot edit if you are not an Admin");
    print("<p>Go Login!<p>");
  print("</div>");
}
?>