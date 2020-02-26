<?php

require (RabbitMQClient.php);

$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = loginMessage($username,$password);







?>
