<?php
//seperate file to space things out and allow pointing to other files. 
require("/var/www/html/it490-project/rmq/RabbitMQClient.php");


$username = $_POST['username'];
$password = $_POST['password'];

$hash = password_hash($password, PASSWORD_BCRYPT); //hashing. 


$rabbitResponse = registerMessage($username,$hash); //registerMessage in RabbitMQClient.php. 

if($rabbitResponse==false){
    echo "account already created";

}else{

    echo "Account is created";

}

//use this to also point to login.php after the user registers. Header()?????????



?>

