<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');
$response = displayMovieList($id);

if($response == false){
    echo "Response is false!";
}else{
    $ulist = json_decode($response, true);
}

if(isset($_POST['submitButton'])){
    try{
        $review = $_POST['review'];
        $title = $_POST['title'];
        $rabbitResponse = movieReviewMessage($id, $review, $title);
        if($rabbitResponse == false){
            echo "Review was not added!";
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
<p>Please Select A Movie and Write a Review:</p>
<form class="form" method="POST" action="#">
    <select id="title" name="title">
        <?php foreach($ulist as $index=>$row):?>
            <option value="<?php echo $row['movie_title']?>"><?php echo $row['movie_title']?></option>
        <?php endforeach;?>
    </select>
    <input name="review" type="text" class="form-control" placeholder="Please write what you think of the movie." required/>
    <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
</form>
<?php
include_once("blade/footer.php");
?>
