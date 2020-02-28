<?php

$host = 'localhost';
$user = 'mark';
$pass = 'markit';
$db = 'it490';
$mysqli = mysqli_connect($host,$user,$pass,$db);

if (mysqli_connect_error()){
    die("Database Connection failed: ".mysqli_connect_error());
}

?>
