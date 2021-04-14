<?php
session_start();

/******************************************************
*
* upload document from user
*
*******************************************************/
$result= "5";

$username=$_SESSION['username'];


$title= $_POST['title'];

$db_host = "mysql1.cs.clemson.edu";
$db_user = "MeTube_tahd";
$db_password = "metube4620";
$db_database = "MeTube_mtiz";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);
// $result = mysqli_query($conn, $query);
       

$playlistCheck = "SELECT * FROM playlists where title='$title'";

//Get USER_ID
echo "$username";
$user_resquest = "SELECT user_id from users where username='$username';";

$numRows = mysqli_num_rows($user_resquest);
if( $numRows == 0 ){ //Make sure the playlist doesnt already exist 

$user_response = mysqli_query($conn, $user_resquest);
$user_id = mysqli_fetch_assoc($user_response)["user_id"];
        
      
$insert = "INSERT INTO playlists( user_id, title, items_count ) VALUES( ".$user_id.", '".$title."', 0); ";
$queryresult = mysqli_query($conn, $insert);



$result = "0";

}
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
