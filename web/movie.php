<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');
$movie_id = $_GET['movie_id'];
$response = displayMoviePage($movie_id);
$reviews = displayMovieReviews($movie_id);
if($response == false ){
    echo "cant display movie!";
}else{
    $list = json_decode($response, true);
    echo "grabbed id, works";
}

?>
    <head>
        <title>New Page Template</title>
    </head>

    <br>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Poster</th>
            <th scope="col">Title</th>
            <th scope="col">Plot</th>
            <th scope="col">Year</th>
            <th scope="col">Length</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $index=>$row):?>
            <tr>
                <?php echo "<td>"."<img src=".$row['poster']." class=\"img-responsive\">"."</td>";?>
                <?php echo "<td>".$row['title']."</td>";?>
                <?php echo "<td>".$row['plot']."</td>";?>
                <?php echo "<td>".$row['year']."</td>";?>
                <?php echo "<td>".$row['length']."</td>";?>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <br>

<?php
include_once("blade/footer.php");
?>