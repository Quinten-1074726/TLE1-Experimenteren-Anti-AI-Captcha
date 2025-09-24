<?php
$host = "127.0.0.1";
$database = "tle1-2";
$user = "root";
$password = "root";

$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());

session_start()

?>