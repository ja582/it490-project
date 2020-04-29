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
        <link rel="stylesheet" href="css/profileStyle.css">
    </head>
    <div class="leftpane">
        <h1>Favorite Movies<h1>
                <?php foreach($favList as $index=>$row): ?>
                    <div class="row">
                        <div class="col">
                            <?php echo "Title ".$row['movie_title'];?>
                        </div>
                    </div>
                <?php endforeach;?>
    </div>
    </div>
    <div class="middlepane">
        <h1>Movie Lists<h1>
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
    </div>
<div class="rightpane">
    <h1>Movie Reviews</h1>
    <br>
    <iframe name=hiddenFrameReview" class="hideReview"></iframe>
    <form class="form-signin" method="POST" action="#">
        <input name="review" type="text" class="form-control" placeholder="write your review"/>
        <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
    </form>
    <script>
        document.getElementById("addList").onclick  = function() {
            var nodeList = document.createElement("Li");
            var textList = document.getElementById("review").value;
            var textnodeList=document.createTextNode(textList);
            nodeList.appendChild(textnodeList);
            document.getElementById("reviewList").appendChild(nodeList);
            //document.getElementById('review').value=null;

        }
    </script>
    <br>
    <?php foreach($reviewList as $index=>$row): ?>
        <div class="row">
            <div class="col">
                <?php echo "Review: ".$row['review'];?>
            </div>
        </div>
    <?php endforeach;?>

</div>

<?php
include_once("blade/footer.php");
?>
