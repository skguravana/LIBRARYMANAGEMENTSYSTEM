<?php 

    $dbhost="localhost";
    $dbuser='system';
    $dbpass="";
    $dbname='lms';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
	echo "connection successfull";

?>