<html>
<?php
include_once('include/dbh.inc.php');
include_once ('include/functions.inc.php');

session_start();

if(!isset($_SESSION['username'])){
  echo "<p>It looks like you are not signed in</p>";
  return;
}if(isset($_POST['newmsg'])){
  $msg = $_POST['newMessage'];
  $cur_user_name = $_SESSION['username'];
  $queryUser = "SELECT user_id FROM users where username='$cur_user_name';";
  $userResult = queryResults($queryUser);
  $cur_user_id = mysqli_fetch_row($userResult)[0];

  $send_to_user = $_POST['sendTo'];
  $queryUser = "SELECT user_id FROM users where username='$send_to_user';";
  $userResult = queryResults($queryUser);
  $cur_contact_id = mysqli_fetch_row($userResult)[0];
  $query = "INSERT INTO messages (sending_user, receiving_user, content)
            VALUES ($cur_user_id, $cur_contact_id, '$msg');";
  $result = queryResults($query);
  // echo "<div id='passwd_result'>".$query."</div>";

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
    $insertQuery_otherDir = "INSERT INTO contacts(user_sender, user_receiver) VALUES (".$contact_user_id.", ".$cur_user_id.");";
    $query_otherDir = mysqli_query($conn, $insertQuery_otherDir);
    // echo "<div id='passwd_result'>".$insertQuery."</div>";
    if($queryresult && $query_otherDir){
      $add_error = "User successfully added as a contact";
    }else{
      $add_error = "Issue adding contact to contact list";
    }
  }
  if(isset($add_error))
   {  echo "<div id='passwd_result'>".$add_error."</div>";}
}else if(isset($_POST['remove'])){
  $remove_error='';
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
  if(empty($remove_error)){
    $insertQuery = "DELETE FROM contacts WHERE user_sender=".$cur_user_id." AND user_receiver=".$contact_user_id.";";
    $queryresult = mysqli_query($conn, $insertQuery);
    $insertQuery = "DELETE FROM contacts WHERE user_sender=".$contact_user_id." AND user_receiver=".$cur_user_id.";";
    $queryresult = mysqli_query($conn, $insertQuery);
    // echo "<div id='passwd_result'>".$insertQuery."</div>";
    if($queryresult){
      $remove_error = "User successfully removed from contacts";
    }else{
      $remove_error = "Issue removing contact from contact list";
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


   ?>
 <head>
 <title>Profile</title>
 <link rel="stylesheet" type="text/css" href="app.css" />
 <link rel="stylesheet" href="header.css" type="text/css">
 <link rel="stylesheet" href="messages.css" type="text/css">
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

       </form>
     </div>
     <br></br>

     <td style="vertical-align: top;">
     <div class="baseroot2" style=" width: fit-content; padding: 3% 5% 3% 5%;">
      <table style="margin-top:3%; ">
        <tr>
        <td  style="padding-left: 20px; margin: auto;">
          <h2 class="mediaDetails" style="text-align: left; vertical-align: top;">Add Contacts</h2>
          <form method="POST" action="contacts.php">
            <input type="submit" name="add" value="Add">
            <input  type="text" name="contact_username" maxlength="30" required>
          </form>
         
      <?php
        $html = '';
        $addcontact = '';
        $textbox = '<div>
          <form method=POST action ="contacts.php">

            <label for="msg"><b>Message</b></label>
            <textarea placeholder="Type message.." name="newMessage" required></textarea>
            <input name="sendTo" value="send to">
            <input class="buttonOnPurple" type="submit" name="newmsg" value="Send">

          </form>
        </div>';
        ?>
        <?php
        $contacts = '<div>
              <h2 style="margin:auto; text-align: center; margin-top: 3%;">Contact List:</h2>
              ';
        if(mysqli_num_rows($contact_result) == 0){
          echo "</br>";
          echo "No Contacts";
        }else{
        $i = 1;
        
        $contactSelect = "";
        while ($contact_result_row = mysqli_fetch_row($contact_result))
        {
         $msg = '<div class="container">';
         $cur_contact = $contact_result_row[0];
         $contactSelect .= '<option value="'.$contact_result_row[0].'">'.$contact_result_row[0].'</option>';
         $queryContact = "SELECT user_id FROM users where username='$cur_contact';";
         $userResult = queryResults($queryContact);
         $cur_contact_id = mysqli_fetch_row($userResult)[0];
         $msg_query = "SELECT content, receiving_user, sending_user FROM messages WHERE receiving_user=$cur_contact_id AND sending_user=$cur_user_id OR (sending_user=$cur_contact_id AND receiving_user=$cur_user_id)";
         $msg_result = mysqli_query($conn, $msg_query);

          if(mysqli_num_rows($msg_result)==0){
            $msg = "No messages with this user";
          }else{
            $j = 1;
            while($msg_result_row = mysqli_fetch_row($msg_result)){
              if($msg_result_row[2]==$cur_contact_id){
              $msg .= '<p class="receiver"> '.$msg_result_row[0].'</p>';
            }else{
              $msg .= '<p class="sender"> '.$msg_result_row[0].'</p>';
            }
              $j += 1;
            }
          }
          $msg .= '</div>';
          $contacts .= '<br></br><li style="text-align: center; list-style-type: none;">'.$cur_contact.'</li>';
          $html .= '<div class="baseroot2" ><h2> Messages with: '.$cur_contact.' </h2> <div style="width: 80%; margin: auto;">'.$msg.'</div></div>';
          $i += 1;

      ?>
          <?php
        }
      
        $textbox = '<div class="baseroot2" style="clear:both; padding-top: 3%;">
        <form method=POST action ="contacts.php">

         <label for="sendTo">Send To: </label>
          <select name="sendTo" id="sendTo" required>'.$contactSelect.'</select></br></br>
          <label for="msg"><b>Message</b></label>
          <textarea placeholder="Type message.." name="newMessage" required></textarea></br>
          
          <input class="buttonOnPurple" type="submit" name="newmsg" value="Send">

        </form>
      </div>';
      }?>

<!-- ENDING DATA COLLECTION -->
          <form method="POST" action="contacts.php">
            <input  type="submit" name="remove" value="Remove">
            <select name="contact_username" id="sendTo" required><?php echo $contactSelect; ?></select>
          </form>
        </td>
        </tr>
      </table>
      </div>
    <?php
    $contacts .= '<ul></div>';
        echo "<div class='baseroot2' >$contacts</div>";
        echo $textbox;
        echo $html;
      ?>

    </td>

   </body>
 </html>
