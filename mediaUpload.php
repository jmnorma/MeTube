<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="stylesheet" href="app.css" type="text/css">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>
</head>

<body class="App">
<h1 style="padding-top: 30px;"> Media Upload </h1>
<form method="post" action="mediaUploadProcess.php" enctype="multipart/form-data" class="baseroot2" style="margin-top: 30px;">
 
  <p style="margin:0; padding: 10px">
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
    <input  name="file" type="file" size="50" />
    
    <input type="radio" id="Video" name="media" value="Video">
      <label for="Video">Video</label>
    <input type="radio" id="Photo" name="media" value="Photo">
      <label for="Photo">Photo</label><br>

    <label for="description">Description</label><br>
      <textarea type="text" cols="60" rows="3" id="Description" name="Description" maxlength="300" required>
      </textarea> <br>

    <label for="category">Category</label><br>
      <textarea type="text" cols="30" rows="1" id="Category" name="Category" maxlength="32" required>
      </textarea><br>

    <label for="keywords">Keywords</label> <br>
      <textarea type="text" cols="60" rows="1" id="Keywords" name="Keywords" maxlength="200" required>
      </textarea> <br>
      
    <br>

	  <input value="Upload" name="submit" type="submit" />
  </p>               
 </form>

</body>
</html>