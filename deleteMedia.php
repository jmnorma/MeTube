<?php 
include_once("include/functions.inc.php");
session_start(); 

$username = $_SESSION['username'];


$media = $_POST['media'];
echo $media;

$queryMedia = "SELECT * FROM Media WHERE media_id='".$media."';";
$mediaResult = queryResults($queryMedia);
$MediaInfo = mysqli_fetch_assoc( $mediaResult);

unlink($MediaInfo["file_ulr"]);


$removeQuery = "DELETE FROM Media WHERE media_id='".$media."';";
queryResults($removeQuery);

?> 
<meta http-equiv="refresh" content="0;url=user.php">