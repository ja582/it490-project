<?php

require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$username = $_POST['username'];
$password = $_POST['password'];

$rabbitResponse = loginMessage($username,$password);

if($rabbitResponse==false){
    echo "login has failed, please try again";
    //redirect back to login page to try again

}else{
    echo "You are logged in!";
    //redirect to homepage or profile page???

}

//we can use this page to point to the home page/login page after user registers and logs in. Header()????
//need to save user credentials somehow to keep user signed in and to have changes from the user to bind to their account



?>
