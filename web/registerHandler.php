<?php

require (testRabbitMQClientSample.php);

$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = registerMessage($username,$password);







?>
