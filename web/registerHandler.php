<?php

require ("rmq/rabbitMQClient.php");


$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = registerMessage($username,$password);







?>
