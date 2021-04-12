<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
    include_once "include/functions.inc.php";
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
if(isset($_GET['id'])) {
	$query = "SELECT * FROM Media WHERE media_id='".$_GET['id']."'";
	$result = queryResults( $query );
	$result_row = mysqli_fetch_assoc($result);


	$filename=$result_row["title"];
	$filepath=$result_row["file_ulr"];
	$type=$result_row["duration"];

	if($type == 0 ) //view image
	{
		
		echo "<img style='margin-top: 5%;' src='".$filepath."'/><br>";

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
}
else
{
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
	<label style="font-size: large" for="cars">Add to Playlist:</label>
		<select name="playlist" id="playlist">
		<?php echo $html; ?>
	</select>
	<input type="submit" value="Add">
	</form>
	</div>

<?php
}
?>

</div>
</body>
</html>