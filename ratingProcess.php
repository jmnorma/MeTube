<?php 

include_once "include/likes.inc.php";
session_start();

$media_id = $_GET['id'];
$user_id = $_GET['uid'];

$like = $_POST['submit'];

if ( strcmp( $like, "Like") == 0 ){
    like_media($user_id,$media_id);
}
else{
    dislike_media($user_id,$media_id);
}


?>
<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $media_id;?>">