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
    </head>

    <br>
    <h1>Movies in the Database</h1>
    <br>
<?php foreach($dblist as $index=>$row): ?>
    <div class="row">
        <div class="col">
            <?php echo "<img src=".$row['poster'].">";?>
        </div>
        <div class="col">
            <?php echo $row['title'];?>
        </div>
        <div class="col">
            <?php echo $row['imdb_id'];?>
        </div>
    </div>
<?php endforeach;?>
    </div>

<?php
include_once("blade/footer.php");
?>