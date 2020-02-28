<?php

require("rmq/rabbitMQClient.php");


$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = registerMessage($username,$password);

if($rabbitResponse==false){
    echo "account already created";

}else{

    echo "Account is created";

}








?>
