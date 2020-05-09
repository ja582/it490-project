<?php
include_once("blade/header.php");
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$response = displayApiDB($id);
if($response == false){
    echo "Response is false!";
}else{
    $dblist = json_decode($response, true);
}

?>

    <head>
        <title>Movie Database</title>
        <style>
            .img-responsive {
                width: auto;
                height: 200px;
            }
        </style>
    </head>

    <br>
    <h1>Movies in the Database</h1>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Poster</th>
            <th scope="col">Title</th>
            <th scope="col">Plot</th>
            <th scope="col">Year</th>
            <th scope="col">Length</th>
            <th scope="col">More Info</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($dblist as $index=>$row):?>
            <tr>
                <?php echo "<td>"."<img src=".$row['poster']." class=\"img-responsive\">"."</td>";?>
                <?php echo "<td>".$row['title']."</td>";?>
                <?php echo "<td>".$row['plot']."</td>";?>
                <?php echo "<td>".$row['year']."</td>";?>
                <?php echo "<td>".$row['length']."</td>";?>
                <?php $movie_id = $row['id']; echo "<td><a href=\"movie.php?movie_id=".$movie_id."\">More Info</a></td>";?>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<?php
include_once("blade/footer.php");
?>