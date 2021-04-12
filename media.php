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
if(isset($_GET['id'])) {
	$query = "SELECT * FROM Media WHERE media_id='".$_GET['id']."'";
	$result = queryResults( $query );
	$result_row = mysqli_fetch_assoc($result);


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
}
else
{
?>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>
</body>
</html>
