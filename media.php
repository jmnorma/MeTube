<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
    include_once "include/functions.inc.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="app.css" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body class="App">
<?php
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
		echo "Viewing Picture:";
		echo $result_row["title"];
		echo "<img src='".$filepath."'/>";
	}
	else //view movie
	{
?>
	<p>Viewing Video:<?php echo $result_row["file_ulr"];?></p>
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


<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>
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
			$html .= '<p> '.$comment_result_row[2].' </p>';

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
