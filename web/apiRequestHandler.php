<?php

session_start();

if ($_SESSION['logged'] != true){
    echo "not logged in";
}
else{
    $newUser = $_SESSION['user']['name'];
}

require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$api=$_POST['api'];


$response = apiRequest($search);

if($response==false){
    echo "ERROR";


}else{

    $apiResult=json_decode($response, true);

    echo $apiResult;
    
    foreach($apiResult["titles"] as $movies){
        echo $movies["title"];
    
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo ('<img height="200px" src"' .$movies['image']. '">');
    echo "<br>";
    echo "<br>";
    echo "<br>";
        
    }
}

?>
