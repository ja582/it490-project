<?php
include_once("blade/header.php");
echo '<br>';
require('/var/www/html/it490-project/rmq/apiMQClient.php');
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

if(isset($_POST['submitButton'])){
    try{
        $apiReq = $_POST['api'];
        $score = $_POST['score'];
        if($score > 10 or $score < 1){
            echo '<b><p class=\"text-danger\">Score is either higher than 10 or lower than 1! Try again.</p></b>';
            return false;
        }
        $rabbitResponse = apiRequest($apiReq);
        if($rabbitResponse == false){
            echo "Movie failed to be added!";
        }else{
            echo '<b><p class=\"text-success\">Movie added!</p></b>';
            apiWriteMessage($rabbitResponse, $score, $id);
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}

?>
    <head>
        <title>Movie API Home</title>
    </head>

    <br>
    <h1 class="h3 mb-3 font-weight-normal">Enter in a Movie</h1>
    <br>
    <p>Please enter in a desired movie title and score. Said movie will be added to your list and the website's <a href="moviedb.php">database</a>.</p>
    <form class="form-signin" method="POST" action="#">
        <input name="api" type="text" class="form-control" placeholder="Enter in Movie Title" required/>
        <input name="score" type="text" class="form-control" placeholder="Enter in a score from 1 to 10" required/>
        <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
    </form>
<?php
include_once("blade/footer.php");
?>