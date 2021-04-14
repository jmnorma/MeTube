<?php
if(isset($_POST['submit'])){

  $msg = $_POST['message'];
  $query = "INSERT INTO messages (sending_user, receiving_user, content)
            VALUES ($_SESSION[username], $_POST[sendTo], '$msg')";
  $result = queryResults($query);

}
 ?>
