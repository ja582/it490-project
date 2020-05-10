<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');
$response = displayApiDB($id);

if($response == false){
    echo "Response is false!";
}else{
    $ulist = json_decode($response, true);
}

if(isset($_POST['submitButton'])){
    try{
        $review = $_POST['reviewDesc'];
        $reviewTitle = $_POST['reviewTitle'];
        $values = $_POST['movie_info'];
        $values_explode = explode('|', $values);
        $title = $values_explode[0];
        $movie_id = $values_explode[1];
        $rabbitResponse = movieReviewMessage($id, $review, $title, $movie_id, $reviewTitle);
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
    <select id="movie_info" name="movie_info">
        <?php foreach($ulist as $index=>$row):?>
            <option value="<?php echo $row['movie_title']?>|<?php echo $row['id']?>"><?php echo $row['movie_title']?></option>
        <?php endforeach;?>
    </select>
    <input name="reviewTitle" type="text" class="form-control" placeholder="Please write a title for your review." required/>
    <input name="reviewDesc" type="text" class="form-control" placeholder="Please write what you think of the movie." required/>
    <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
</form>
<?php
include_once("blade/footer.php");
?>
