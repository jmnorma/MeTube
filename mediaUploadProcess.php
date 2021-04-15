<?php
session_start();

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];


//Create Directory if doesn't exist
if(!file_exists('uploads/'))
	mkdir('uploads/', 0761);
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
	mkdir($dirfile, 0761);


	if($_FILES["file"]["error"] > 0 )
	{ $result=$_FILES["file"]["error"];
		// echo "Here -1";
		echo "$result";
	} //error from 1-4
	else
	{
	//   echo "Here -2";
	  $upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
	  if(file_exists($upfile))
	  {
			// echo "Here 0";
	  		$result="5"; //The file has been uploaded.
	  }
	  else{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				// echo "Here 1";
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					// echo "Here 3";
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					$duration = 1; 
					$durationValue = $_REQUEST['media'];
					if( strcmp( $durationValue, "Photo") == 0 ){
						$duration = 0; 
					}
					// echo "$duration";

					$title = $_POST['title'];
					$description = $_POST['Description'];
					$category = $_POST["Category"];
					$keyword = $_POST["Keywords"];
					
                    $db_host = "mysql1.cs.clemson.edu";
                    $db_user = "MeTube_tahd";
                    $db_password = "metube4620";
                    $db_database = "MeTube_mtiz";
            
                    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);
                    // $result = mysqli_query($conn, $query);
                    
                    //Get USER_ID
					// echo "$username";
                    $user_resquest = "SELECT user_id from users where username='$username';";
                    $user_response = mysqli_query($conn, $user_resquest);
                    $user_id = mysqli_fetch_assoc($user_response)["user_id"];
					
					$file_url = $dirfile .urlencode($_FILES["file"]["name"]);
					//insert into media table
					$insert = "insert into Media(
							user_id, duration, date_uploaded, title , description, category, file_ulr, keywords)".
							  "values( $user_id, $duration, '". date("Y-m-d") ."','".$title."', '".$description."', '".$category."','". $file_url ."', '".$keyword."');";
					// echo "$insert";
					$queryresult = mysqli_query($conn, $insert);
						//   or die("Insert into Media error in media_upload_process.php " .mysql_error());
					$result="0";
					
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	}
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
