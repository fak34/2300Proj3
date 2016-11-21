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
  
  <h1>Edit or Delete an Image</h1>
  <form action="edit.php" method="post">
<?php
    require_once 'config.php'; 
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    $newsql = $mysqli->query("SELECT * FROM photos ORDER BY pTitle");
    print("<p>Select Image to edit</p>");
    print("<select name=\"image_list\">");
    while($row = $newsql->fetch_assoc()){
        print("<option value=\"{$row['pTitle']}\">
              {$row['pTitle']}</option>");
    }
    print("</select>");
?>
  <h2>New Caption</h2>
  Title: <input type="text" name="newCaption">
  Description: <input type="text" name="newDescription">
  <br>
  <input name="submit" type="submit" value="Edit Image">
  <br><br>
  <h1>Delete an Image</h1>
  <p>Type "delete" into text area to delete</p>
  <input type="text" name="delete">
  <br><br>
  <input name="submit1" type="submit" value="Delete Image">
  </form>
<?php
    if(isset($_POST['submit'])){
        $img1 = $_POST['image_list'];
        $title1 = $_POST['newCaption'];
        $newDesc = $_POST['newDescription'];
        require_once 'config.php'; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if(isset($img1)){
            if(isset($title1)&&(strlen($title1))>0){
                if (!preg_match('/^[a-zA-Z0-9]+/',$title1)){
                    echo 'Invalid Pic Title. Only numbers and letters. Try again.';
                }
                else{
                $newsql1 = "UPDATE photos SET pTitle = '$title1' WHERE pTitle = '$img1'";
                $result1 = $mysqli->query($newsql1);
                print("<p>Image has been edited</p>");
                }
            }
        }
        if(isset($img1)){
            if(isset($newDesc)&&(strlen($newDesc))>0){
                if (!preg_match('/^[a-zA-Z0-9]+/',$title1)){
                    echo 'Invalid Pic Title. Only numbers and letters. Try again.';
                }else{
                $newsql1 = "UPDATE photos SET pDesc = '$newDesc' WHERE pTitle = '$img1'";
                $result1 = $mysqli->query($newsql1);
                print("<p>Image has been edited</p>");
                }
            }
        }
    }
    if(isset($_POST['submit1'])){
        $img1 = $_POST['image_list'];
        require_once 'config.php'; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if(isset($_POST['delete'])&&trim($_POST['delete'])=='delete' && strlen($_POST['delete'])>0){
            $newsql2 = "DELETE FROM photos WHERE pTitle = '$img1'";
            $result2 = $mysqli->query($newsql2);
            print("<p>Image has been deleted</p>");
        }else{
            print("Have to type in 'delete'");
        }
    }
?>
</body>
</html>