<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="stylesheet" href="header.css" type="text/css">
<?php
	session_start();
	include_once "include/functions.inc.php";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="app.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">

function saveDownload(id)
{
	readfile(id)
}

</script>
</head>

<body class="App">

<!-- Header/Tool Bar-->

<div class="App-header">
	<a class="home" href="browse.php">MeTube</a>
	<?php if( isset($_SESSION['username'])){ ?>
	<a class="home" href='mediaUpload.php'>Upload</a>
	<?php } ?>
	<form method="post" action="searchResults.php?id=1">

	<?php 
		if( isset($_SESSION['username'])){
			$username = $_SESSION['username'];
		echo '<a class="upload" href="user.php">'.$username.'</a>'; 
		echo "<a class='upload' href='logout.php'>logout</a>";
		}
		else {
			echo "<a class='upload' href='index.php'>Log In</a>";
		}

	?>
	<div class="upload">
	
	<input class="searchButton" name="Search" type="submit" value="Search">
	<input class="search" id="SearchValue" name="SearchValue" style="color: black;" type="text" placeholder="Search..">
	</div>
</form>
</div>

<div style="padding-top: 10px;"></div>
<div class="baseroot2">

<div id='upload_result'>
<?php
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{

		echo upload_error($_REQUEST['result']);

	}
?>
</div>
</br>
<?php
	$query = "SELECT * from Media";
	$result = queryResults( $query );

	$category_query = "SELECT * FROM Media GROUP BY category;";
	$category_result = queryResults($category_query);


	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}


	$deleteHtml = '';
	while ($result_row = mysqli_fetch_row($category_result))
	{
		$deleteHtml .=  '<option value="'.$result_row[6].'">'.$result_row[6].'</option>';
	}
?>
	<div class="Playlist-header" style="margin-top: 1%; min-height: 0px; width: 25%; float: right; margin-right: 3%;">
		<form method="post" action="browse.php">
			<label style="font-size: large" for="media">Category: </label>
				<select name="category" id="category">
				<?php echo $deleteHtml; ?></select>
			<input class="newPlaylist" name="filter" type="submit" value="Filter">	
		</form> 
	</div>

    <div style="display: table; clear:both; ">
    <div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; ">Uploaded Media</div>
	</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php

			if ( isset($_POST['category'])){
				$category_filter= $_POST['category'];
				$query = "SELECT * from Media WHERE category='$category_filter';";
				$result = queryResults( $query );
			}

			$html = '';
			$totalItemPerLine = 3;
			$i = 0;

			while ($result_row = mysqli_fetch_row($result))
			{
				if( $i % $totalItemPerLine == 0 ){
					$html .= '<div class="row">'; // New Row
				}
				$html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="media.php?id='.$result_row[0].'" >'.$result_row[4].'</a><br><a href="'.$result_row[7].'" target="_blank" onclick="javascript:saveDownload('.$result_row[7].');">Download</a></div></div></div>';

				if($i % $totalItemPerLine == ($totalItemPerLine-1))
				{
					$html .= '</div>'; // End Row
				}
				$i += 1;

		?>

        <?php
			}

			if($i % $totalItemPerLine != ($totalItemPerLine-1)){
                $html .= '</div>';
            }

			echo $html;
		?>
	</table>
		</div>


	<!-- GET PLAYLISTS -->

<div class="baseroot2" >

<div class="Playlist-header" style="margin-top: 10px;">
<?php if( isset($_SESSION['username'])){ ?>
<form method="post" action="createNewPlaylist.php">
<input class="newPlaylist" name="createNewPlaylist" type="submit" value="Create New Playlist">	
</form> 
<?php } ?>
</div>

<?php
	$query = "SELECT * from playlists WHERE title!='My Favorites'"; 
	$result = queryResults( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <div style="display: table;">
    <div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; ">All Playlists</div>
	</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			$html = '';
			$totalItemPerLine = 3;
			$i = 0; 

			while ($result_row = mysqli_fetch_assoc($result))
			{ 
				if( $i % $totalItemPerLine == 0 ){ 
					$html .= '<div class="row">'; // New Row 
				}
				$html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="playlist.php?id='.$result_row["playlist_id"].'" >'.$result_row["title"].'</a><br><h3>'.$result_row["items_count"].' Items </div></div></div>';

				if($i % $totalItemPerLine == ($totalItemPerLine-1))
				{
					$html .= '</div>'; // End Row
				}
				$i += 1;
				
		?>
			
        <?php
			}

			if($i % $totalItemPerLine != ($totalItemPerLine-1)){
                $html .= '</div>';
            }

			echo $html;
		?>
	</table>
		</div>


</body>
</html>
