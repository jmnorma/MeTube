<html>
<?php
include_once('include/dbh.inc.php');
include_once ('include/functions.inc.php');

session_start();

if(!isset($_SESSION['username'])){
  echo "<p>It looks like you are not signed in</p>";
  return;
}
if(isset($_POST['add'])){
  $add_error='';
  $contact_name = $_POST['contact_username'];
  $query = "SELECT user_id FROM users where username='$contact_name';";
  $contact_result = queryResults($query);
  $contact_user_id = mysqli_fetch_row($contact_result)[0];
  if(mysqli_num_rows($contact_result) == 0) {
  echo "<p>No user found by that name!</p>";
  }
  //current user id
  $cur_user_name = $_SESSION['username'];
  $queryUser = "SELECT user_id FROM users where username='$cur_user_name';";
  $userResult = queryResults($queryUser);
  $cur_user_id = mysqli_fetch_row($userResult)[0];
  if(mysqli_num_rows($userResult) == 0){
    echo "<p>No user logged in</p>";
  }
  if(empty($add_error)){
    $insertQuery = "INSERT INTO contacts(user_sender, user_receiver) VALUES (".$cur_user_id.", ".$contact_user_id.");";
    $queryresult = mysqli_query($conn, $insertQuery);
    // echo "<div id='passwd_result'>".$insertQuery."</div>";
    if($queryresult){
      $add_error = "User successfully added as a contact";
    }else{
      $add_error = "Issue adding contact to contact list";
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
 <?php
 $cur_user_name = $_SESSION['username'];
 $queryUser = "SELECT user_id FROM users where username='$cur_user_name';";
 $userResult = queryResults($queryUser);
 $cur_user_id = mysqli_fetch_row($userResult)[0];
 $contact_query = "SELECT username FROM users, contacts WHERE users.user_id=contacts.user_receiver AND contacts.user_sender=$cur_user_id";
 $contact_result = mysqli_query($conn, $contact_query);


 $msg_query = "SELECT content FROM messages, users, contacts WHERE users.user_id=contacts.user_receiver AND contacts.user_sender=$cur_user_id";
 $msg_result = mysqli_query($conn, $contact_query);
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
      <h1>Contacts:</h1>
      <?php
        $html = '';
        if(mysqli_num_rows($contact_result) == 0){
          echo "</br>";
          echo "No Contacts";
        }else{
        $i = 1;

        while ($contact_result_row = mysqli_fetch_row($contact_result))
        {
          if(mysqli_num_rows($msg_result)==0){
            $msg = "No messages with this contact";
          }else{
            $j = 1;
            while($message_result_row = mysqli_fetch_row($msg_result)){
              $msg .= '<p> '.$message_result_row[0].' </p>';
              $j += 1;
            }
          }
          $html .= '<p> '.$contact_result_row[0].' </p></br> '.$msg.'';

          $i += 1;

      ?>

          <?php
        }
      }
        echo $html;
      ?>
    </td>

   </body>
 </html>
