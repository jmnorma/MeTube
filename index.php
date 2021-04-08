<?php 
    include_once('include/functions.inc.php');
    session_start();

if(isset($_POST['submit'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
			if($check == 1) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				header('Location: browse.php');
			}		
		}
}

?>

<!DOCTYPE html>
<link rel="stylesheet" href="app.css" type="text/css">
<html>
    <head>
        <title>MeTube Sign-In</title>
    </head>

    <img src="metubeWhite.png" alt="MeTube Logo" class="Complete-logo">
        <b>
            Created by Dylan and Josh 
        </b>

    <body class="App">
        <div class="baseroot">
        <div>
        <h2>
            Please Log-In
        </h2>

        <form method="post" action="<?php echo "index.php"; ?>">
            <table width="100%" class="root2">
                <tr>
                    <td  width="40%">Username:</td>
                    <td width="60%"><input class="text"  type="text" name="username"><br /></td>
                </tr>
                <tr>
                    <td  width="20%">Password:</td>
                    <td width="80%"><input class="text"  type="password" name="password"><br /></td>
                </tr>
               
            </table>
                <input name="submit" type="submit" value="Login">
                <input name="reset" type="reset" value="Reset"> <br>
                    <div style="padding-top: 10px;"></div>
                <input name="create" type="button" value="Create New Account"/>
        </form>
        </div>
        </div>

     
    </body>
</html>

<?php
  if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
?>