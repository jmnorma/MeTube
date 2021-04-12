<?php 
    session_start();
    include_once "include/functions.inc.php";

    $playlistID = $_GET['id'];
      
    
    $removeQuery = "DELETE FROM playlist_items WHERE playlist_id='".$playlistID."';";
    queryResults($removeQuery);

    $removeQuery = "DELETE FROM playlists WHERE playlist_id='".$playlistID."';";
    queryResults($removeQuery);
    
    ?> 
    <meta http-equiv="refresh" content="0;url=browse.php">

