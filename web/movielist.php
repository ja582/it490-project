<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

//RMQ stuff
$response = displayMovieList($id);
if($response == false){
    echo "Response is false!";
}

$list = json_decode($response, true);

if(isset($_POST['submitButton'])){
    try{
        $mvt = $_POST['movie_title'];
        $score = $_POST['score'];
        $rabbitResponse = createMovieMessage($mvt, $score, $id);
        if($rabbitResponse == false){
            echo "adding movie failed";
        }else{
            echo "movie added";
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}
?>

    <head>
        <title>Movie List Creator</title>
    </head>

    <br>
    <form class="form-signin" method="POST" action="#">
        <h1 class="h3 mb-3 font-weight-normal">enter in a movie</h1>
        <input name="movie_title" type="text" class="form-control" placeholder="movie title" required autofocus/>
        <input name="score" type="text" class="form-control" placeholder="score" required autofocus/>
        <br>
        <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
    </form>
    <br>
<?php foreach($list as $index=>$row): ?>
    <div class="row">
        <div class="col">
            <?php echo "Title ".$row['movie_title'];?>
        </div>
        <div class="col">
            <?php echo "Score ".$row['score'];?>
        </div>
    </div>
<?php endforeach;?>
<?php
include_once("blade/footer.php");
?>