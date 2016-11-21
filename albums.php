<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<?php
include 'newNav.php';
?>
  <div id= "center1";
        <p>Albums</p>
    </div>
<?php

echo "<div class = 'alb'>";

require_once 'config.php'; 
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if (isset($_GET['aID'])){
    $thisalbum = $_GET['aID'];

    $result = ("SELECT * FROM photosInAlbum INNER JOIN photos ON photosInAlbum.pID = photos.pID
                         INNER JOIN albums ON photosInAlbum.aID = albums.aID
                         WHERE albums.aID = $thisalbum");
    
    
    
    $images = $mysqli->query($result);
    
    while ( $row = $images->fetch_assoc() ) {
        
        $url = $row['file_path'];
        $caption = $row['pDesc'];
        $pID = $row['pID'];
        print("<div class = 'imgcontainer'>");
            print("<a href=photoDetail.php?pID=$pID><img src = $url></a></img>");
            print("\n<br>\n");
            print("<div class='caption'>$caption</div>");
        print("</div>");
        //echo "</div>";
    
}
//while ( $row = $a->fetch_assoc() ) {
   // $url = $row['file_path'];
    //print("<img src = $url> </img>");
    
}

else{
    $albums = $mysqli->query("SELECT * FROM albums");
    while ( $row = $albums->fetch_assoc() ) {
        $aName = $row['aName'];
        $aID = $row['aID'];
        print("<div class = 'albname'>");
            print("<a href=albums.php?aID=$aID>$aName</a>");
            print("\n<br>\n");
        print("</div>");

    }
}   

    
echo "</div>";


?>

</body>
</html>
