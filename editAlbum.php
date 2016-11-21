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
  <h1>Choose Album to Edit or Delete</h1>
  
  <form action = "editAlbum.php" method ="post">
<?php  
    require_once 'config.php'; 
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    $albumSql = $mysqli->query("SELECT * FROM albums ORDER BY aName");
    print("<h2>Select an Album to Update</h2>");
    print("<select name =\"album_list\">");
    while($row = $albumSql->fetch_assoc()){
        print("<option value=\"{$row['aName']}\">
              {$row['aName']}</option>");
    }
    print("</select>");
?>
  
  <script type="text/javascript" src="script.js"></script>
  <h2>Edit Album Name</h2>
  New Name: <input type="text" name="newaName">
  <br>
  <br>
  <input name="submit" type="submit" value="Update Album">
<?php
    require_once 'config.php'; 
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    $imgSql = $mysqli->query("SELECT * FROM photos ORDER BY pID");
    print("<h2>Select an Existing Image to Include</h2>");
    print("<select name =\"image_list\">");
    while($row = $imgSql->fetch_assoc()){
        print("<option value=\"{$row['pTitle']}\">
              {$row['pTitle']}</option>");
    }
    print("</select>");
?>
  <input name="submit2" type="submit" value="AddExImage">
  <br><br>
  <h1>Delete an Album</h1>
  <p>Type "delete" into text area to delete</p>
  <input type="text" name="delete">
  <br><br>
  <input name="submit1" type="submit" value="Delete Album" >
  
  </form>

<?php
    $date = date('Y-m-d H:i:s');
    if(isset($_POST['submit'])){
        $list = $_POST['album_list'];
        $newName = $_POST['newaName'];
        require_once 'config.php'; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if(isset($list)){
            if(isset($newName)&&strlen($newName)>0){
                if (!preg_match('/^[a-zA-Z0-9]+/',$newName)){
                    echo 'Invalid title. Only numbers and letters. Try again.';
                }
                else{
                    $albsql = "UPDATE albums SET aName = '$newName', aDate_Modified = '$date' WHERE aName = '$list'";
                    $result = $mysqli->query($albsql);
                    print("<p>Album Name has been Edited.</p>");
                }
            }
        }
    }
    if(isset($_POST['submit2'])){
        $list1 = $_POST['image_list'];
        $list = $_POST['album_list'];
        require_once 'config.php'; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if(isset($list1)){
                $joinsql = "SELECT photosInAlbum.aID FROM albums INNER JOIN photosInAlbum ON albums.aID=photosInAlbum.aID WHERE  aName = '$list' LIMIT 1";
                $joinsql1 = "SELECT photosInAlbum.pID FROM photos INNER JOIN photosInAlbum ON photos.pID = photosInAlbum.pID WHERE pTitle = '$list1' LIMIT 1";
                $derp = $mysqli->query($joinsql);
                $derp1 = $mysqli->query($joinsql1);
                while ($row = $derp->fetch_assoc()){
                    $newaID = $row['aID'];
                }
                while ($row = $derp1->fetch_assoc()){
                    $newpID = $row['pID'];
                }
                $imgsql = "INSERT INTO photosInAlbum (pID,aID) VALUES ($newpID,$newaID)";
                $datesql = "UPDATE albums SET aDate_Modified = '$date'";
                $result = $mysqli->query($imgsql);
                $result3 = $mysqli->query($datesql);
                print("<p>Image has been Added.</p>");
            }
        }
    
    if(isset($_POST['submit1'])){
        $list = $_POST['album_list'];
        $list1 = $_POST['image_list'];
        require_once 'config.php'; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
            if(isset($_POST['delete'])&&trim($_POST['delete']) =='delete' && strlen($_POST['delete'])>0){
                $albsql1 = "DELETE FROM albums WHERE aName = '$list'";
                $relsql1 = "DELETE FROM photosInAlbum WHERE pID = '$list1";
                $result1 = $mysqli->query($albsql1);
                $result2= $mysqli->query($relsql1);
                print("<p>Album has been deleted</p>");
            }else{
                print("Have to type in 'delete'");
    }
            
    }   
    
?>
</body>
</html>