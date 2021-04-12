<?php
    session_start(); 
    include_once "include/functions.inc.php";

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="app.css" type="text/css">
<link rel="stylesheet" href="header.css" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Playlist</title>
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
	$query = "SELECT * FROM playlists WHERE playlist_id='".$_GET['id']."'";
	$result = queryResults( $query );
	$result_row = mysqli_fetch_assoc($result);
	
	
	$title=$result_row["title"];
    $user_id = $result_row["user_id"];
    $playlist_id  = $_GET['id'];

    //PLAYLIST QUERY WITH MEDIA
    $query = "SELECT Media.media_id, Media.title, Media.file_ulr FROM Media INNER JOIN playlist_items ON playlist_items.media_id = Media.media_id WHERE playlist_items.playlist_id = ".$playlist_id.";";
    $result = queryResults( $query );

    $userValidate = "SELECT user_id FROM users WHERE username='".$username."';";
    $userResult = queryResults( $userValidate );
    $userRow = mysqli_fetch_row( $userResult );
    
    if( $userRow[0] == $user_id){
        ?>
            <div class="Playlist-header" style="margin-top: 10px;">
            <?php
            echo '<form method="post" action="deletePlaylist.php?id='.$_GET['id'].'" >';
            ?>
            <input class="newPlaylist" name="DeletePlay" type="submit" value="Delete Playlist">	
            </form> 
            </div>
        <?php
    }

    ?>
    <br/>
    <div style="display: table;">
    
    <div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; "><?php echo $title; ?> </div>
	</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			$html = '';
			$totalItemPerLine = 3;
			$i = 0; 

			while ($result_row = mysqli_fetch_row($result))
			{ 
				if( $i % $totalItemPerLine == 0 ){ 
					$html .= '<div class="row">'; // New Row 
				}
				$html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="media.php?id='.$result_row[0].'" >'.$result_row[1].'</a><br><a href="'.$result_row[2].'" target="_blank" onclick="javascript:saveDownload('.$result_row[2].');">Download</a></div></div></div>';

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
 
</div>
<?php
}
?>
</body>
</html>