<?php

require("/var/www/html/it490-project/rmq/RabbitMQClient.php");


$username = $_POST['username'];
$password = $_POST['password'];

$hash = password_hash($password, PASSWORD_BCRYPT);

$rabbitResponse = registerMessage($username,$hash);

if($rabbitResponse==false){
    echo "account already created";
    header("Location: registerError.php");
}else{

    echo "Account is created";
    header("Location: login.php");

   


}








?>
