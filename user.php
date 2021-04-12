<?php
include_once("include/functions.inc.php");
session_start();


$username=$_SESSION['username'];

if(!isset($_SESSION['username'])) {
	echo "<p class=\"errorText\">It looks like you aren't logged in.
		  This page is inaccessible until you log in or create your account.</p>";
	return;
  }

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
    <a class="upload" href='logout.php'>logout</a>

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
</div>
</table>
</div>

<?php

if(isset($_POST['submit'])) {
    if($_POST['newemail'] != "") {
      $newemail = $_POST['newemail'];
      $query = "SELECT email_address FROM users WHERE email_address='$newemail' AND
                username IN (SELECT username FROM users WHERE username!='$_SESSION[username]')";
      if(!($result = mysqli_query($conn, $query))) {
        die("<p>Error changing email address</p>");
      }
      if(mysqli_num_rows($result)) {
        $error="<p>Email address already exists.</p>";
      }
      else { // update email address
        $query = "UPDATE users SET email_address='$newemail'
                  WHERE username='$_SESSION[username]'";
        if (!($result = mysqli_query($conn, $query))) {
          die("<p>Could not update your email address at this time.</p>");
        }
        else {
          echo "<p>Email address updated successfully</p>";
        }
      }
    }
    if($_POST['newpass'] != "") {
      $newpass = $_POST['newpass'];
      if($newpass != "") {
        // update password
        $query = "UPDATE users SET password='$newpass' WHERE username='$_SESSION[username]'";
        if(!($result = mysqli_query($conn, $query))) {
          die("<p>Could not update your password at this time (No Update)</p>");
        }
        else {
          echo "<p>Password updated successfully</p>";
        }
      }
    }
    if($_POST['newusername'] != ""){
      $newusername = $_POST['newusername'];
      $query = "SELECT username FROM users WHERE username='$newusername' AND username IN
              (SELECT username FROM users WHERE username!='$_SESSION[username]')";
      if(!($result = mysqli_query($conn, $query))) {
        die("<p>Could not update your username at this time (No Validation)</p>");
      }
      if(mysqli_num_rows($result) > 0){
        $error="<p>Username already exists</p>";
      }
      else {
      $query = "UPDATE users SET username='$newusername' WHERE username='$_SESSION[username]'";
        if(!($result = mysqli_query($conn, $query))){
          die("<p>Could not update username</p>");
        }
      $_SESSION['username']=$newusername;
      echo "<p>Username updated successfully</p>";
      }
    }

  if(isset($error)) {
  echo $error;
  }
}
?>

  <div class="baseroot2">
    <br></br>
    <table style="background-color: #EBBAB9; width: 80%; margin: auto; border: none; border-radius: 4px; padding: 4px;">
    <tr><td><p>You can change your account information here.</p></td></tr>
    <tr><td>
      <form method="POST" action="<?php echo "user.php"; ?>">
      <table cellspacing="0" cellpadding="0">
      </table>
    </td></tr>
    <tr><td>
      <table>
      <p class="generalText" style="padding-bottom: 1em;">
        Leave fields with their starting values or blank if you do not wish to change them
      </p>
        <table style="margin: auto;">
          <tr class="makealignright">
            <td>Email Address:</td>
            <td><input class="orangefield" type="text" name="newemail" value="">
            </td>
          </tr>
          <tr class="makealignright">
          <td class="generalText">New Password:</td>
          <td><input class="orangefield" type="text" name="newpass" value""></td>
          </tr>
          <tr class="makealignright">
            <td class="generalText">Username:</td>
            <td><input class="orangefield" type="text" name="newusername" value""></td>
            </td>
          </tr>
          <tr><td><input class="btn btn-primary" name="submit" type="submit" value="Submit"></td></tr>
        </table>
      </form>
      </table>
    </td></tr>
    </table>
	</div>
  </body>
</html>
