<?php

require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = loginMessage($username,$password);

if($rabbitResponse==false){
    echo "login has failed, please try again";
    header("Location: loginError.php");

}else{
    echo "You are logged in!";
    header("Location: profile.php");


}

//we can use this page to point to the home page/login page after user registers and logs in. Header()????
//need to save user credentials somehow to keep user signed in and to have changes from the user to bind to their account



?>
