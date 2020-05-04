<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

//Displaying movie lists
$response = displayMovieList($id);
$responseA = displayFavMovie($id);
$responseB = displayReviews($id);

if($response == false && $responseA == false && $responseB == false ){
    echo "Response is false!";
}

$list = json_decode($response, true);
$favList = json_decode($responseA, true);
$reviewList = json_decode($responseB, true);


if(isset($_POST['submitButton'])){
    try{
        $rvw = $_POST['review'];
        $rabbitResponse = movieReviewMessage($rvw, $id);
        if($rabbitResponse == false){
            echo "adding review failed";
        }else{
            echo "review added";
            header("location: profile.php");
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}

?>

<head>
    <title>User Profile</title>
    <style>
        .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px;}
        .hideReview { position:absolute; top:-1px; left:-1px; width:1px; height:1px;}
        .home { right:200px;}
    </style>
</head>
<div class="row rounded">
    <div class="col">
        <h2>Favorite Movies</h2>
        <p>
            <?php foreach($favList as $index=>$row): ?>
        <div class="row">
            <div class="col">
                <?php echo $row['movie_title'];?>
            </div>
        </div>
        <?php endforeach;?>
        </p>
    </div>
    <div class="col">
        <h2>Movie List</h2>
        <p>
            <?php foreach($list as $index=>$row): ?>
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Score</th>
            </tr>
            </thead>
            <tbody>
            <tr><td><?php echo $row['movie_title'];?></td></tr>
            <tr><td><?php echo $row['score'];?></td></tr>
            </tbody>
        </table>
        <?php endforeach;?>
        </p>
    </div>
    <div class="col">
        <h2>Movie Reviews</h2>
        <p>

        <form class="form-signin" method="POST" action="#" target="hiddenFrameReview">
            <input name="review" type="text" class="form-control" placeholder="write your review"/>
            <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
        </form>
        </p>
    </div>
</div>
<?php
include_once("blade/footer.php");
?>
