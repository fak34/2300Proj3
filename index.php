<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<?php
include 'newNav.php';
?>
<div id = "center2">
  <h3>Welcome to the Underground Gallery</h3>
</div>
<?php
  echo "<div class = 'alb'>";
  require_once 'config.php'; 
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
  $result = ("SELECT * FROM photos");
  $allImages = $mysqli->query($result);
  while ( $row = $allImages->fetch_assoc() ) {
    $url = $row['file_path'];
    $caption = $row['pTitle'];
    $pID = $row['pID'];
      print("<div class = 'imgcontainer'>");
          print("<a href=photoDetail.php?pID=$pID><img src = $url></a></img>");
          print("\n<br>\n");
          print("<div class='caption'>$caption</div>");
      print("</div>");
  }
  echo "</div>";
    
    
?>
 
</body>
</html>