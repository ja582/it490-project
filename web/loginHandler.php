<?php

require('rmq/RabbitMQClient.php');

$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = loginMessage($username,$password);

if($rabbitResponse==false){
    echo "login has failed, please try again";

}else{
    echo "You are logged in!";


}






?>
