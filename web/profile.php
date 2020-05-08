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



$x = 1;
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
                <?php echo $row['movie_title'];?>
            <?php endforeach;?>
        </p>
    </div>
    <div class="col">
        <h2>Movie List</h2>
        <p>
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Score</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $index=>$row):?>
                <tr>
                    <?php echo "<td>".$row['movie_title']."</td>";?>
                    <?php echo "<td>".$row['score']."</td>";?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        </p>
    </div>
    <div class="col">
        <h2>Movie Reviews</h2>
        <p>
            <?php foreach($reviewList as $index=>$row): ?>
                <?php echo $row['review'];?>
            <?php endforeach;?>
        <br>
        </p>
    </div>
</div>
<?php
include_once("blade/footer.php");
?>
