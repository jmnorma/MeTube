<?php
include_once("include/functions.inc.php");
session_start();


$username=$_SESSION['username'];



$queryUser = "SELECT user_id FROM users where username='$username';";
$userResult = queryResults($queryUser);
$user_id = mysqli_fetch_row($userResult)[0];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="stylesheet" href="header.css" type="text/css">
<link rel="stylesheet" href="app.css" type="text/css">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Account</title>
</head>

<body class="App">
    
<div class="App-header"> 
	<a class="home" href="browse.php">MeTube</a>
	<a class="home" href='mediaUpload.php'>Upload</a>

</div> 

<h1 style=" background-color: #08415C; width: 60%; clear: both; margin: auto;" > <?php echo "$username"; ?> </h1>

<div class="baseroot2" style="margin-top: 0px;">
<br/><br/>
<?php
	$query = "SELECT * from Media where user_id=$user_id"; 
	$result = queryResults( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <div style="display: table;">
    <div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; "><?php echo "$username"; ?>'s Media</div>
	</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			$html = '';
            $deleteHtml = '';
			$totalItemPerLine = 3;
			$i = 0; 

			while ($result_row = mysqli_fetch_row($result))
			{ 
				if( $i % $totalItemPerLine == 0 ){ 
					$html .= '<div class="row">'; // New Row 
				}
				$html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="media.php?id='.$result_row[0].'" target="_blank">'.$result_row[4].'</a><br><a href="'.$result_row[7].'" target="_blank" onclick="javascript:saveDownload('.$result_row[7].');">Download</a></div></div></div>';
                $deleteHtml .=  '<option value="'.$result_row[0].'">'.$result_row[4].'</option>';
				
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
        <div style="padding-top: 35px; clear: both; "> </div>
        <div style="padding: 1px; background-color: #08415C;  margin: auto; width: 80% "> </div>
        <div class="App-header" >
        <form method="post" action="deleteMedia.php" enctype="multipart/form-data">
        <label style="font-size: large" for="cars">Delete Media:</label>
            <select name="media" id="media">
            <?php echo $deleteHtml; ?>
        </select>
        <input type="submit" value="Delete">
        </form>
        </div>
	</table>
	
	<!-- PLAYLISTS  -->
	<br/><br/>
	<?php 
	$query = "SELECT * from playlists where user_id=$user_id"; 
	$result = queryResults( $query );
	?>

	<div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; "><?php echo "$username"; ?>'s Playlists</div>
	
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			$html = '';
            $deleteHtml = '';
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

		</div>
    </div>
</body>
</html>