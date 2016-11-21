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
  <h1> Add an Album</h1> <br>

    <form action="addAlbum.php" method="post">
    Title: <input type="text" name="title">
    <br>
    Add Album <input type="submit" name = "submit">
    
<?php

$date = date('Y-m-d H:i:s');
if(isset($_POST['submit'])){
    
    $title = $_POST['title'];
    if (!preg_match('/^[a-zA-Z0-9]+/',$title)){
        echo 'Invalid title. Only numbers and letters. Try again.';
    }
    
    if(empty($title)){
        echo "Have to fill in title field";
    }
    
    //validate here
    
    require_once 'config.php'; 
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    
    $sql = "INSERT INTO albums (aName, aDate_Created, aDate_Modified)
    VALUES('$title','$date','$date')";
            
    $mysqli->query($sql);
  
    
}


?>

    </form>
    
    <h2>Upload an Image</h2>
    <br>
    <form action="addAlbum.php" method="post" enctype="multipart/form-data">
    Title: <input type="text" name="atitle">
    <br><br>
    Description: <input type="text" name="pictureDescription">
    <br>
    Credit (link): <input type="text" name="credit">
    <input type= "file" name="fileToUpload" id="fileToUpload">
    <br><br>
    Album:
    <br>
<?php

require_once 'config.php'; 
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

$albums = $mysqli->query("SELECT * FROM albums");
    while ( $row = $albums->fetch_assoc() ) {
        $aName = $row['aName'];
        $aID1 = $row['aID'];
        print("<input type='checkbox' name='albumCheckbox[]' value= ".$aID1.">".$aName."<br>");
    
    }
?>
    <br>
    <input type='submit' value='Upload Image' name='submit1'>
    
    </form>
<?php
    if(isset($_POST['submit1'])){
        $caption = $_POST['pictureDescription'];
        $aTitle = $_POST['atitle'];
        $credit = $_POST['credit'];
        if(isset($_POST['albumCheckbox'])){ 
            $checkbox_array = $_POST['albumCheckbox'];
        }
        if(!empty($_FILES['fileToUpload'])&&isset($caption)&&isset($credit)&&isset($aTitle)){
            if (!preg_match('/^[a-zA-Z0-9]+/',$aTitle)){
                echo 'Invalid title. Only numbers and letters. Try again.';
            }
            if (!preg_match('/^[a-zA-Z0-9]+/',$caption)){
                echo 'Invalid Description. Only numbers and letters. Try again.';
            }
            $newphoto = $_FILES['fileToUpload'];
            $originalName = $newphoto['name'];       
            if($newphoto['error'] == 0){
                $tempname = $newphoto['tmp_name'];
                move_uploaded_file($tempname,"photos/$originalName");
                $_SESSION['photos'][]= $originalName;
                print("<p>$originalName uploaded</p>");
                require_once 'config.php'; 
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
                $sql = "INSERT INTO photos (pTitle,pDesc,credit,file_path)
                        VALUES ('$aTitle','$caption','$credit','photos/$originalName')";
                $result = $mysqli->query($sql);
                $img_result = $mysqli->query("SELECT pID FROM photos ORDER BY pID DESC LIMIT 1");
                $last_image_row = $img_result->fetch_row();
                $last_photo_id = $last_image_row[0];
            if(isset($_POST['albumCheckbox'])){
                foreach ($checkbox_array as $element){
                    require_once 'config.php'; 
                    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
                    $aID = intval($element);
                    $sql_relation = "INSERT INTO photosInAlbum (pID,aID) VALUES ('$last_photo_id','$aID')";
                    $relationResult = $mysqli->query($sql_relation);
                }
            }
            else{
                $sql_relation1 = "INSERT INTO photosInAlbum pID, aID VALUES ('$last_photo_id,'0')";
                $relation_result1 = $mysqli->query($sql_relation1);
            }
        }
            else{
                print("<p>Error: file was not uploaded </p>");
            }
    }else{
         print("Description, Credit, and File fields have to be completed");
    }
    
    }
    }else{
        print("<div class = 'adminMsg'>");
            print("<p>You cannot edit if you are not an admin</p>");
            print("<p>Go to Login Page</p>");
        print("</div>");
    }

?>
</body>
</html>