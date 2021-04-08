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
	<a class="home" href="">MeTube</a>
	<a class="home" href='mediaUpload.php'>Upload</a>
	
	<form method="post" action="browse.php">
	<?php 
		$username = $_SESSION['username'];
		echo '<a class="upload" href="user.php">'.$username.'</a>'; 
	?>

	<div class="upload">
	<input class="searchButton" name="Search" type="submit" value="Search">	
	<input class="search" type="text" placeholder="Search..">	
	</div>
</form>
</div> 

<div style="padding-top: 30px;"></div>
<div class="baseroot2">

<div id='upload_result'>
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{
		
		echo upload_error($_REQUEST['result']);

	}
?>
</div>
<br/><br/>
<?php
	$query = "SELECT * from Media"; 
	$result = queryResults( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <div style="display: table;">
    <div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; ">Uploaded Media</div>
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
				$html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="media.php?id='.$result_row[0].'" target="_blank">'.$result_row[4].'</a><br><a href="'.$result_row[7].'" target="_blank" onclick="javascript:saveDownload('.$result_row[7].');">Download</a></div></div></div>';

				if($i % $totalItemPerLine == ($totalItemPerLine-1))
				{
					$html .= '</div>'; // End Row
				}
				$i += 1;
				
		?>
			
        <?php
			}
			echo $html;
		?>
	</table>
		</div>
</body>
</html>
