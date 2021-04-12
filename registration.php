<?php
include_once('include/dbh.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])){
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $email_address = trim($_POST['email_address']);

  if($query = $conn->prepare("SELECT * FROM users WHERE username = ?")){
    $reg_error='';

  $query->execute();
  $query->store_result();

    if($query->num_rows > 0){
      $reg_error = "This username is already in use";
    } else {
      if(strlen($password)<6){
        $reg_error = "Password length must be at least 6";
      }
      if (empty($error)){
        $insertQuery = $conn->prepare("INSERT INTO users (username, password, email_address) VALUES (?, ?, ?);");
        $insertQuery->bind_param("sss", $username, $password, $email_address);
        $result = $insertQuery->execute();
        if($result){
          $reg_error = "Registration Successful";
        } else {
          $reg_error = "Issue creating account";
        }
      }
    }
  }
  $query->close();
  $insertQuery->close();
  mysqli_close($conn);
}
 ?>

<!DOCTYPE html>
<link rel="stylesheet" href="app.css" type="text/css">
<html>
  <head>
    <title>Register</title>
  </head>
  <body class="App">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Register Account</h2>
          <p>Fill out all the information below to create an account.</p>
          <form action="" method="post">
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input type="text" name="email_address" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="text" name="password" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="submit" name="create" class="btn btn-primary" value="create">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>


<?php
 if(isset($reg_error))
  {  echo "<div id='passwd_result'>".$reg_error."</div>";}
?>
