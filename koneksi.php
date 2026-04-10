<?php
$hostname = "localhost";
$username = "root";
$password = ""; 
$database = "db_streaming"; 
$con = mysqli_connect($hostname, $username, $password, $database);

if ($con) {
    mysqli_set_charset($con, "utf8mb4");
}

?>
