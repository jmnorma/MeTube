<?php
include_once('include/dbh.inc.php');

if(isset($_POST['newMessage'])){
  
  $msg = $_POST['message'];
  $query = "INSERT INTO messages (sending_user, receiving_user, content)
            VALUES ($_SESSION[username], $_POST[sendTo], '$msg')";
  $result =
}
 ?>
