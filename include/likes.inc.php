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