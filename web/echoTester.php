<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

if(isset($_POST['submitButton'])){
    try{
        $writeMsg = $_POST['msg'];
        $response = echoMessage($writeMsg);
        if($response == false){
            echo "didnt work";
        }else{
            echo "it worked";
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}
?>


    <head>
        <title>test for echo</title>
    </head>

    <br>
    <form class="form-signin" method="POST" action="#">
        <input name="msg" type="text" class="form-control" placeholder="message" required autofocus/>
        <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
    </form>

<?php
include_once("blade/footer.php");
?>