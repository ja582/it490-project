<?php
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');
$movie_id = $_GET['movie_id'];
$response = displayMoviePage($movie_id);
$reviews = displayMovieReviews($movie_id);

if($response == false ){
    echo "cant display movie!";
}else{
    $list = json_decode($response, true);
    $rlist = json_decode($reviews, true);
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
<?php foreach($rlist as $index=>$row):?>
    <br>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['reviewTitle']; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted">By User #<?php echo $row['user_id']; ?></h6>
            <p class="card-text"><?php echo $row['review']; ?></p>
        </div>
    </div>
    <br>
<?php endforeach;?>
<?php
include_once("blade/footer.php");
?>