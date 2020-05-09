<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');


if(isset($_POST['submitButton'])){
    try{
        
        $review = $_POST['review'];
        $rabbitResponse = movieReviewMessage($id, $review);
        if($rabbitResponse == false){
            echo "didnt work";
        }else{
            echo '<b><p class=\"text-success\">Review added!</p></b>';
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}

?>
    <head>
        <title>Movie Review Home</title>
    </head>

    <br>
    <h1 class="h3 mb-3 font-weight-normal">Enter in a Movie Review</h1>
    <br>
    <p>Please enter in a movie review</p>
    <form class="form-signin" method="POST" action="#">
        <input name="review" type="text" class="form-control" placeholder="Movie Title - Review" required/>
        <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
    </form>
<?php
include_once("blade/footer.php");
?>
