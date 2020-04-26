<?php

session_start();

if ($_SESSION['logged'] != true){
    echo "not logged in";
}
else{
    $newUser = $_SESSION['user']['name'];
}



require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

// if(isset($_POST['submit'])){

$movieText=$_POST['movieText'];


movieFavMessage($newUser, $movieText);
// }


?>
