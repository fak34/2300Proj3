<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<?php
include 'newNav.php';
?>
  
    <h1>Search Photo Details</h1>
    
    <p>Enter all or part of the details below</p>
    <br>
    <form action="search.php" method="post">
    Field: <input type="text" name="field">
    <br><br>
    <input name= "Search" value="Search" type="submit" >
    </form>
<?php
    if(isset($_POST['Search'])){
        if(!empty($_POST['field'])){
          if (!preg_match('/^[a-zA-Z0-9]+/',htmlentities($_POST['field']))){
                echo 'Invalid field search. Only numbers and letters. Try again.';
            }
            $search = trim($_POST['field']);
            $sql = "SELECT * FROM photos WHERE pTitle LIKE '%$search%' OR pDesc LIKE '%$search%'";  
            $sql1 = "SELECT * FROM albums WHERE aName LIKE '%$search%'";
            require_once 'config.php';
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
            $result = $mysqli->query($sql);
            $result1 = $mysqli->query($sql1);
            while($row1=$result1->fetch_assoc()){
                $aName = $row1['aName'];
                print("<br>");
                print("Album: $aName");
                print("<br>");
            }   
            while($row = $result->fetch_assoc()){
                $url = $row['file_path'];
                $caption = $row['pTitle'];
                $desc = $row['pDesc'];
                $pID = $row['pID'];
                echo "<div class = 'alb'>";
                print("<div class = 'imgcontainer'>");
                    print("<a href=photoDetail.php?pID=$pID><img src = $url></a></img>");
                    print("<br>");
                    print("Title: <div class='caption'>$caption</div>");
                    print("<br>");
                    print("Description:<div class='caption'>$desc</div>");
                print("</div>");
                echo"</div>";
            }
        }
        else{
            print("Please enter text to search");
          }   
    }
    