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
        $movie_id = $_POST['movie_id'];
        echo $movie_id;
        $rabbitResponse = listManagerDel($movie_id);
        if($rabbitResponse == false){
            echo "didnt work";
        }else{
            echo "Movie deleted!";
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}

?>

    <head>
        <title>User List Management</title>
    </head>
    <br>

    <h1>List Manager</h1>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Score</th>
            <th scope="col">Delete?</th>
        </tr>
        </thead>
        <tbody>
        <form class="form-signin" method="POST" action="#">
            <?php foreach($ulist as $index=>$row):?>
                <tr>
                    <?php echo "<td>".$row['movie_title']."</td>";?>
                    <?php echo "<td>".$row['score']."</td>";?>
                    <td><input type="radio" name="movie_id" value="<?php echo $row['id'] ?>"></td>
                </tr>
            <?php endforeach;?>
            <br>
            <br>
            <input type="submit" value="Delete Movie" name="submitButton" id="submitButton"/>
        </form>
        </tbody>
    </table>

<?php
include_once("blade/footer.php");
?>