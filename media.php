<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
    include_once "include/functions.inc.php";
	include_once "include/likes.inc.php";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="app.css" type="text/css">
<link rel="stylesheet" href="header.css" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body class="App">

<div class="App-header">
	<a class="home" href="browse.php">MeTube</a>

	<?php
		if( isset($_SESSION['username'])){
			$username = $_SESSION['username'];
		echo '<a class="upload" href="user.php">'.$username.'</a>';
		}
	?>
</div>


<div class="baseroot2">
<?php
if(isset($_POST['removeComment'])){
	$comment = $_POST['removeComment'];
	$query = "DELETE FROM comments WHERE comment_id=$comment";
	$result = queryResults($query);
}
if(isset($_POST['reply'])) { // post a reply to the discussion
	$user = $_SESSION['username'];
	$query = "SELECT user_id FROM users WHERE username='user';";
	if(!($result = mysqli_query($conn, $query))) {
		die("<p>Error accessing account</p>");
	}else{
		$user_id = mysqli_fetch_assoc($result);
	}

	$query = "INSERT INTO comments (user_id, content, media_id) VALUES ('$user_id', '$_POST[commentText]','$_GET[id]')";
	if(!($result = mysqli_query($conn, $query))) {
		echo "<p>Could not create your comment at this time</p>";
	}
}
if(isset($_GET['id'])) {
	$query = "SELECT * FROM Media WHERE media_id='".$_GET['id']."'";
	$result = queryResults( $query );
	$result_row = mysqli_fetch_assoc($result);

	$comment_query = "SELECT * FROM comments WHERE media_id='".$_GET['id']."'";
	$comment_result = mysqli_query($conn, $comment_query);
	// $comment_data = mysqli_fetch_assoc($comment_result);


	$filename=$result_row["title"];
	$filepath=$result_row["file_ulr"];
	$type=$result_row["duration"];

	if($type == 0 ) //view image
	{

		echo "<img style='margin-top: 5%;  width: 80%; height: 60%; object-fit: contain;' src='".$filepath."'/><br>";

		echo "Viewing Picture:";
		echo $result_row["title"];
	}
	else //view movie
	{
		?>
		<p>Viewing Video:<?php echo $result_row["file_ulr"];?></p><br>
		<?php
		$video_location = $result_row['file_ulr'];
		echo '<video width="320" height="240" controls autoplay muted>';

		echo '<source src='.$video_location.' type="video/mp4">';
		?>
		Your browser does not support the video tag.
		</video>
	</object>

<?php
	}
} else {
?>

</div>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>

<!-- Add to Playlist  -->

<?php

if( isset($_SESSION['username'])){

	$userValidate = "SELECT user_id FROM users WHERE username='".$username."';";
	$userResult = queryResults( $userValidate );
	$user_id = mysqli_fetch_row( $userResult )[0];


	$query = "SELECT * FROM playlists WHERE user_id=".$user_id.";";
	$result = queryResults( $query );

	$html = '';
	$totalItemPerLine = 3;
	$i = 0;

	while ($result_row = mysqli_fetch_row($result))
	{
		if( $i % $totalItemPerLine == 0 ){
			$html .= '<div class="row">'; // New Row
		}
		$html .=  '<option value="'.$result_row[0].'">'.$result_row[2].'</option>';

		if($i % $totalItemPerLine == ($totalItemPerLine-1))
		{
			$html .= '</div>'; // End Row
		}
		$i += 1;
	}

?>
	<div style="padding-top: 35px; clear: both; "> </div>
	<div style="padding: 1px; background-color: #08415C;  margin: auto; width: 80% "> </div>
	<div class="App-header" >
	<form method="post" action="addToPlaylist.php?id=<?php echo $_GET['id'];?>" enctype="multipart/form-data">
	<label style="font-size: large" for="playlist">Add to Playlist:</label>
		<select name="playlist" id="playlist">
		<?php echo $html; ?>
	</select>
	<input type="submit" value="Add">
	</form>
	</div>

<!-- Method for Liking and Disliking media -->
<?php
	$media_id = $_GET['id'];
	$likeQuery = "SELECT SUM(CASE WHEN type=True THEN 1 ELSE 0 END) , SUM(CASE WHEN type=False THEN 1 ELSE 0 END) FROM ratings WHERE media_id=$media_id ;";
	$result = queryResults($likeQuery);
	$ratings = mysqli_fetch_row($result);
	if ( $ratings[0]== NULL ){
		$likeNum = 0;
		$dislikeNum = 0;
	}
	else{	
		$likeNum = $ratings[0];
		$dislikeNum = $ratings[1];
	}
	echo "$likeNum Likes ";
	echo " $dislikeNum Dislikes ";
	?>
	<form method="post" action="ratingProcess.php?id=<?php echo $_GET['id'];?>&uid=<?php echo $user_id;?>" enctype="multipart/form-data">
	<input type="submit" id="submit" name="submit" value="Like">
	<input type="submit" id="submit" name="submit" value="Dislike"> 
	</form>

	<?php
	
}
?>

</div>
<table width="50%" cellpadding="0" cellspacing="0">
	<?php
		$html = '';
		if(mysqli_num_rows($comment_result) == 0){
			echo "</br>";
			echo "No Comments on this post";
		}else{
		$i = 1;

		while ($comment_result_row = mysqli_fetch_row($comment_result))
		{
			$html .= '<p> '.$comment_result_row[2];
		
			$html .= '<form action="" method="post">
			<input type="submit" name="submit" value="Delete">
			<input type="hidden"  name="removeComment" value='.$comment_result_row[0].'>
			</form></p>';
			$i += 1;

	?>

			<?php
		}
	}
		echo $html;
	?>
</br>
	<form method="POST" id="makecomment">
		<textarea class="field" rows="4" cols="50" name="commentText" maxlength="1000" required="true"></textarea></br>
		<input class="buttonOnOrange" type="submit" name="reply" value="Comment">
	</form>
</table>


</body>
</html>
