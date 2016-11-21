<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<?php
include 'newNav.php';
?>
<?php
    require_once 'config.php'; 
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    if (isset($_GET['pID'])){
        $thisphoto = $_GET['pID'];
        $result = ("SELECT * FROM photos WHERE pID = $thisphoto");
        $query = $mysqli->query($result);
        $result2 = ("SELECT albums.aName FROM photos INNER JOIN photosInAlbum ON photos.pID = photosInAlbum.pID
                    INNER JOIN albums ON photosInAlbum.aID = albums.aID WHERE photos.pID = $thisphoto");
        //print($mysqli->error);
        $query2 = $mysqli->query($result2);
    
        while ( $row = $query->fetch_assoc() ) {
            $pTitle = $row['pTitle'];
            $pID = $row['pID'];
            $pDesc = $row['pDesc'];
            $pCredit = $row['credit'];
            $url = $row['file_path'];
            echo "<div class = 'alb1'>";
                print("<div class = 'imgcontainer'>");
                    print("<img src = $url></img>");
                    print("<br>");
                    print("Picture ID:<div class='caption'>$pID</div>");
                    print("<br>");
                    print("Title: <div class='caption'>$pTitle</div>");
                    print("<br>");
                    print("Description:<div class='caption'>$pDesc</div>");
                    print("<br>");
                    print("Credit:<div class='caption'>$pCredit</div>");
                    print("<br>");
                    print("Album(s):<div class='caption'>");
                    while($row2 = $query2->fetch_assoc()){
                        print $row2['aName'] . ' ' ;    
                    }
                    print("</div>");
                print("</div>");
            echo "</div>";
    
        }
    }

?>