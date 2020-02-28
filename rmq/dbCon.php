<?php

$host = '192.168.1.51';
$user = 'root';
$pass = 'markit';
$db = 'it490';
$mysqli = mysqli_connect($host,$user,$pass,$db);

if (mysqli_connect_error()){
    die("Database Connection failed: ".mysqli_connect_error());
}

?>
