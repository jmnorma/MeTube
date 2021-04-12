<?php 
    session_start();
    include_once "include/functions.inc.php";

    $playlistID = $_GET['id'];
      
    
    $removeQuery = "DELETE FROM playlist_items WHERE playlist_id='".$playlistID."' AND media_id=".$_GET['media'].";";
    queryResults($removeQuery);


    $currentQuery = "SELECT items_count FROM playlists WHERE playlist_id=".$playlistID.";";
    $results = queryResults($currentQuery);
    $row = mysqli_fetch_row( $results)[0];
    $row = $row - 1;

    $updateQuery = "UPDATE playlists SET items_count=".$row." WHERE playlist_id=".$playlistID.";";
    queryResults($updateQuery);

    
    ?> 
    <meta http-equiv="refresh" content="0;url=playlist.php?id= <?php echo $playlistID; ?>">