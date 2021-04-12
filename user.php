<html>
<?php
	session_start();
	include_once "include/functions.inc.php";
  include_once('include/dbh.inc.php');

  if(!isset($_SESSION['username'])) {
  echo "<p class=\"errorText\">It looks like you aren't logged in.
        This page is inaccessible until you log in or create your account.</p>";
  return;
}
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
<head>
<title>Profile</title>
<link rel="stylesheet" type="text/css" href="app.css" />
<link rel="stylesheet" href="header.css" type="text/css">
</head>

  <body class="App">

  <!-- Header/Tool Bar-->

    <div class="App-header">
    	<a class="home" href="browse.php">MeTube</a>
    	<a class="home" href='mediaUpload.php'>Upload</a>

      	<form method="post" action="browse.php">
        <div class="logout">
          <a class="logout" href='logout.php'>logout</a>
        </div>
				<div class="contacts">
					<a class="contacts" href='contacts.php'>contacts</a>
				</div>
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
    <br></br>
    <table style="background-color: #c1ade5; border: none; border-radius: 4px; padding: 4px;">
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
        <table>
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
  </body>
</html>
