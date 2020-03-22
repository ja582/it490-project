<?php

$host = 'localhost';
$user = 'keo6';
$pass = 'Foobar123!';
$db = 'IT490';
$mysqli = mysqli_connect($host,$user,$pass,$db);

if (mysqli_connect_error()){
    die("Database Connection failed: ".mysqli_connect_error());
}

?>
