<?php
session_start();
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$username = $_POST['username'];
$password = $_POST['password'];

//$hash = password_hash($password, PASSWORD_BCRYPT);

$rabbitResponse = loginMessage($username,$password);

if($rabbitResponse==false){
    echo "login has failed, please try again";
    header("Location: loginError.php");

}else{
    echo "You are logged in!";
    $userSes = json_decode($rabbitResponse, true);
    $_SESSION['logged'] = true;
    $_SESSION['user'] = $userSes;
    //echo var_export($_SESSION['user']['name']);
    header("Location: profile.php");


 }



?>

