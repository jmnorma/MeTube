<?php 


    function like_media ( $user_id, $media_id){
        $db_host = "mysql1.cs.clemson.edu";
        $db_user = "MeTube_tahd";
        $db_password = "metube4620";
        $db_database = "MeTube_mtiz";

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);
        $query = "SELECT * FROM ratings  WHERE user_id='$user_id' AND media_id='$media_id' AND type=True;";
        $result = mysqli_query($conn, $query);

        if ( !mysqli_num_rows($result)){
            $likeQuery = "INSERT INTO ratings (media_id, user_id, type) VALUES ($media_id, $user_id, True);";
            mysqli_query($conn, $likeQuery);

            $favorites_pid = "SELECT * FROM playlists WHERE user_id='$user_id' AND title='My Favorites';";
            $favorites_result = mysqli_query($conn, $favorites_pid);
            $favorite = mysqli_fetch_row($favorites_result)[0];

            $insertQuery = "INSERT INTO playlist_items (playlist_id, media_id) VALUES( ".$favorite.", ".$media_id.");";
            mysqli_query($conn, $insertQuery);

            $currentQuery = "SELECT items_count FROM playlists WHERE playlist_id=".$favorite.";";
            $results = mysqli_query($conn, $currentQuery);
            $row = mysqli_fetch_row( $results)[0];
            $row = $row + 1;

            $updateQuery = "UPDATE playlists SET items_count=".$row." WHERE playlist_id=".$favorite.";";
            mysqli_query($conn, $updateQuery);
        }


       
        
      
    }

    function dislike_media ( $user_id, $media_id){
        $db_host = "mysql1.cs.clemson.edu";
        $db_user = "MeTube_tahd";
        $db_password = "metube4620";
        $db_database = "MeTube_mtiz";

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);
        $query = "SELECT * FROM ratings  WHERE user_id='$user_id' AND media_id='$media_id' AND type=False;";
        $result = mysqli_query($conn, $query);

        if ( !mysqli_num_rows($result)){
            $likeQuery = "INSERT INTO ratings (media_id, user_id, type) VALUES ($media_id, $user_id, False);";
            mysqli_query($conn, $likeQuery);
        }
      
    }
?>