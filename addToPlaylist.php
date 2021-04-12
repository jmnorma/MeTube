<?php 
include_once("include/functions.inc.php");
session_start(); 

$username = $_SESSION['username'];


$playlist = $_POST['playlist'];


$insertQuery = "INSERT INTO playlist_items (playlist_id, media_id) VALUES( ".$playlist.", ".$_GET["id"].");";
queryResults($insertQuery);

$currentQuery = "SELECT items_count FROM playlists WHERE playlist_id=".$playlist.";";
$results = queryResults($currentQuery);
$row = mysqli_fetch_row( $results)[0];
$row = $row + 1;



$updateQuery = "UPDATE playlists SET items_count=".$row." WHERE playlist_id=".$playlist.";";
queryResults($updateQuery);

?> 
<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id']; ?>">