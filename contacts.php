<html>
<?php
include_once('include/dbh.inc.php');

session_start();

if(!isset($_SESSION['username'])){
  echo "<p class=\"errorText\">It looks like you are not signed in</p>";
  return;
}
if(isset($_POST['add'])){
  //contact id
  $contact_name = $_POST['contact_username'];
  $query = "SELECT user_id from users where username='$contact_name';";
  $result = mysqli_query($conn, $query);
  $contact_user_id = mysqli_fetch_assoc($result)["user_id"];
  if(mysqli_num_rows($result) == 0) {
  echo "<p>No user found by that name!</p>";
  }
  //current user id
  $cur_user_name = $_SESSION['username'];
  $query = "SELECT user_id from users where username='$cur_user_name';";
  $result_user = mysqli_query($conn, $cur_user_name);
  $cur_user_id = mysqli_fetch_assoc($result_user)["user_id"];
  if(mysqli_num_rows($result_user) == 0){
    echo "<p>No user logged in</p>";
  }
  else{
    if($query = $conn->prepare("SELECT contact_id FROM contacts WHERE user_reciever='$cur_user_id' AND user_sender = '$contact_user_id'")){
      $add_error = '';
    $query->execute();
    $query->store_result();
    if($query->num_rows >0){
      $add_error = "Contact already existing";
    }
    if(empty($add_error)){
      $insertQuery = $conn->prepare("INSERT INTO contacts(user_sender, user_reciever) VALUES ($cur_user_id, $contact_user_id)");
      $insertQuery->bind_param("ss", $cur_user_id, $contact_user_id);
      $result = $insertQuery->execute();
      $insertQuery->store_result();
      if($result){
        $add_error = "User successfully added as a contact";
      }else{
        $add_error = "Issue adding contact to contact list";
      }
    }
  }
}
if(isset($add_error))
 {  echo "<div id='passwd_result'>".$add_error."</div>";}
}else if(isset($_POST['remove'])){
  if($query = $conn->prepare("SELECT user_id FROM users WHERE username='$_POST[deleteuser]'")){
    $remove_error = '';
    $query->execute();
    $query->store_result();
    $result = $query->fetch();
    if($query->num_rows == 0){
      $remove_error = "User does not exist";
    }else{
      $reciever_user_id = $row['user_reciever'];
      $cur_user_id = $row['user_sender'];
      if($query = $conn->prepare("DELETE FROM contacts WHERE user_reciever=$reciever_user_id and user_sender=$cur_user_id")){
        $remove_error = '';
        $success = $query->execute();
        if($success){
          $remove_error = "Contact was successfully removed";
        }else{
          $remove_error = "Issue with removing contact";
        }
        $query->store_result();
      }
    }
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

     <td style="vertical-align: top;">
      <table>
        <tr>
        <td style="padding-left: 20px;">
          <p class="mediaDetails" style="text-align: center; vertical-align: top;">Add Contacts</p>
          <form method="POST" action="contacts.php">
            <input class="buttonOnPurple" type="submit" name="add" value="Add">
            <input class="orangefield" type="text" name="contact_username" maxlength="30" required>
          </form>
        </td>
        </tr>
      </table>
    </td>

   </body>
 </html>
