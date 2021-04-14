<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="stylesheet" href="header.css" type="text/css">
<?php
	session_start();
	include_once "include/functions.inc.php";
    include_once "include/filters.inc.php";    
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

<?php
  if( isset($_POST['SearchValue'])){
    ?>
    <meta http-equiv="refresh" content="0;url=searchResults.php?id=1&SearchValue=<?php echo $_POST['SearchValue'];?>">
    <?php
}
?>
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

<div style="padding-top: 30px; clear:both;"></div>

<div style="clear: both;">
        <div style="width: 80%; min-height: 15px; clear:both; margin: auto;">    
            <a class="Tabs" style="border-radius: 10px 0px 0px 0px; border-width: thick thin thin thick;" href="searchResults.php?id=1&SearchValue=<?php echo $_GET['SearchValue']; ?>">By Keyword</a>
            <a class="Tabs" href="searchResults.php?id=2&SearchValue=<?php echo $_GET['SearchValue']; ?>">By Title</a>
            <a class="Tabs" href="searchResults.php?id=3&SearchValue=<?php echo $_GET['SearchValue']; ?>">By Category</a>
            <a class="Tabs" href='searchResults.php?id=4&SearchValue=<?php echo $_GET['SearchValue']; ?>'>By User</a>
            <a class="Tabs" style="border-radius: 0px 10px 0px 0px; border-width: thick thick thin thin;" href='searchResults.php?id=5&SearchValue=<?php echo $_GET['SearchValue']; ?>'>By Playlist</a>
        </div>
</div>
<div style=" clear:both;"></div>
<div class="baseroot2" style="margin-top: 0px;">

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
	$query = getQueryString( $_GET['id'], $_GET['SearchValue']);
	$result = queryResults( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    <div style="display: table;">
    <div class="mediaText" style="background:#339900;color:#FFFFFF; width:200px; height: 40px; display: table-cell; font-size: x-large; ">Search Results</div>
	
</div>
<h2>Results for: <br/><?php echo $_GET['SearchValue'];?> </h2>
<br/>Filtered: <?php echo filter_type($_GET['id']);?>

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
                
                switch( $_GET['id']){
                    case 1:
                    case 2:
                    case 3: 
                        $html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="media.php?id='.$result_row[0].'" >'.$result_row[4].'</a><br><a href="'.$result_row[7].'" target="_blank" onclick="javascript:saveDownload('.$result_row[7].');">Download</a></div></div></div>';
                        break;
                    case 4:
                        $html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="user.php?id='.$result_row[0].'" >'.$result_row[1].'</a></div></div></div>'; 
                        break;
                    case 5:
                        $html .= '<div class="col"> <div class="media"> <div class="mediaText" > <a  href="playlist.php?id='.$result_row[0].'" >'.$result_row[2].'</a><br><h3>'.$result_row[3].' Items </div></div></div>';      
                        break;
                }
				

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