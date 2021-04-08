<?php 
    include_once "dbh.inc.php";
?>

<?php
    function user_pass_check($username, $password)
    {
        $db_host = "mysql1.cs.clemson.edu";
        $db_user = "MeTube_tahd";
        $db_password = "metube4620";
        $db_database = "MeTube_mtiz";

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);
        $query = "select * from users where username='$username'";
        $result = mysqli_query($conn, $query);
            
        if (!$result)
        {
           die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
        }
        else{
            $row = mysqli_fetch_assoc($result);
            if(strcmp($row["password"],$password)){
                $temp = $row["password"];
                echo "$temp";
                return 2; //wrong password
            }    
            else 
                return 0; //Checked.
        }	
    }

    function queryResults( $query = ""){
        $db_host = "mysql1.cs.clemson.edu";
        $db_user = "MeTube_tahd";
        $db_password = "metube4620";
        $db_database = "MeTube_mtiz";

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);
        $result = mysqli_query($conn, $query);

        return $result;
    }

    ?>
