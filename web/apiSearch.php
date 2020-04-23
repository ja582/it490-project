<?php
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

if(isset($_POST['submitButton'])){
    try{
        $apiReq = $_POST['api'];
        $response = apiRequest($apiReq);
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
        <title>API Search function</title>
    </head>

    <br>
    <form class="form-signin" method="POST" action="#">
        <input name="api" type="text" class="form-control" placeholder="movie, actor, etc." required autofocus/>
        <br>
        <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
    </form>

<?php
include_once("blade/footer.php");
?>