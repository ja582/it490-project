<?php

session_start();

if ($_SESSION['logged'] != true){
    echo "not logged in";
}
else{
    $newUser = $_SESSION['user']['name'];
}

require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$response = displayFavMovie($newUser);

if ($response ==false){

    echo "ERROR";
    header("Location: profile.php");
}
else{

    $favs = json_decode($response, true);

    echo $favs;

    echo "<br>";
    echo "<br>";

    echo "<a href='profile.php' >Return to Profile </a>";
}







?>
