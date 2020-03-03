<?php

require("/var/www/html/it490-project/rmq/RabbitMQClient.php");


$username = $_POST['username'];
$password = $_POST['password'];

$hash = password_hash($password, PASSWORD_BCRYPT); //hashing. 


$rabbitResponse = registerMessage($username,$hash);

if($rabbitResponse==false){
    echo "account already created";

}else{

    echo "Account is created";

}

//use this to also point to login.php after the user registers. Header()?????????



?>

