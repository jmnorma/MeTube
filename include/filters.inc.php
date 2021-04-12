<?php 

function filter_type($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
    case 1: 
        return "By Keyword";
	case 2:
		return "By Title";
	case 3:
		return "By Category";
	case 4:
		return "By User";
	case 5:
		return "By Playlist";
	}
}

function getQueryString( $ID, $SearchValue ){
	switch ($ID){
		case 1:
			return "SELECT * FROM Media WHERE keywords LIKE '%$SearchValue%';";
		case 2:
			return "SELECT * FROM Media WHERE title LIKE '%$SearchValue%';";
		case 3:
			return "SELECT * FROM Media WHERE category LIKE '%$SearchValue%';";
		case 4: 
			return "SELECT * FROM users WHERE username LIKE '%$SearchValue%';";
		case 5: 
			return "SELECT * FROM playlists WHERE title LIKE '%$SearchValue%';";	
	}
}
?>

