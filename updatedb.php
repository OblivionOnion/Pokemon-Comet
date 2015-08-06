<?php
require('stuff/connect.php');
$action                 = $_POST['action'];
$updateRecordsArray     = $_POST['recordsArray'];
 
if ($action == "updateRecordsListings"){
 
    $listingCounter = 1;
    foreach ($updateRecordsArray as $recordIDValue) {
 
        $query = "UPDATE pokemon SET position = " . $listingCounter . " WHERE id = " . $recordIDValue;
        mysql_query($query) or die('Error, insert query failed');
        $listingCounter = $listingCounter + 1;
    }
 
}
?>
