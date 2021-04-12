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
        $query = "SELECT password FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        if (!$result)
        {
           die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
        }
        else {
          if(!mysqli_num_rows($result)) {
            return 1; // username not found
          }
          $row = mysqli_fetch_row($result);
          if(strcmp($row[0],$password)) {
            return 2; // Wrong password
          }
          else {
            return 0; // Checked
          }
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
