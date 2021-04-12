<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="stylesheet" href="app.css" type="text/css">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Playlist</title>
</head>

<body class="App">
<h1 style="padding-top: 30px;"> Create New Playlist </h1>
<form method="post" action="createNewPlaylistProcess.php" enctype="multipart/form-data" class="baseroot2" style="margin-top: 30px;">
 
  <p style="margin:0; padding: 10px">
   
    <label for="title">Title</label><br>
      <input type="text" cols="30" rows="1" id="title" name="title" maxlength="300" required> <br>
      
    <br>

	  <input value="Upload" name="submit" type="submit" />
  </p>               
 </form>

</body>
</html>