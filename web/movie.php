<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');
$movie_id = $_GET['movie_id'];
$response = displayMoviePage($movie_id);
if($response == false ){
    echo "cant display movie!";
}else{
    $list = json_decode($response, true);
    var_dump($list);
    //$movie_title = $list['title'];
    echo "grabbed id, works";
}

?>
    <head>
        <title>New Page Template</title>
    </head>

    <br>

<?php
include_once("blade/footer.php");
?>