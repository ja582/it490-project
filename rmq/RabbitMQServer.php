<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require('dbCon.php');


function loginMessage($username,$password){

    //TODO validate user credentials
    //new branch

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();



    if($result->num_rows == 0 || !password_verify($password, $user['password']) ){ //0 meaning that a row was not found with the username and passwor
        $mysqli->close();
        echo "account does not exist or the username/password are incorrect";
        return false;
    }
    else if($result->num_rows !== 0 && password_verify($password, $user['password'])) { //row was found in the table, meaning an account exists
        $mysqli->close();
        $userSes = array("name"=> $user['username']);
        echo "logging in";
        return json_encode($userSes);




    }
    else{
        $mysqli->close();
        echo "account does not exist or the username/password are incorrecct";
        return false;
    }






}

function movieFavMessage($newUser, $movieText){

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "INSERT INTO favoriteMovies (username, movieText) VALUES ('$newUser', '$movieText')";

    if ($mysqli->query($sql)==TRUE){
        echo "Record created successfully";


    }
    else{

        echo "ERROR: " .$sql. "<br>" .$mysqli->error;

    }

    $mysqli->close();


}

function movieReviewMessage($newUser, $review){

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "INSERT INTO reviews (username, review) VALUES ('$newUser', '$review')";

    if ($mysqli->query($sql)==TRUE){
        echo "Record created successfully";
    }
    else{
        echo "ERROR: " .$sql. "<br>" .$mysqli->error;

    }

    $mysqli->close();


}

function displayReviews($newUser){

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT * FROM reviews WHERE username = '$newUser'");
    $reviews = array();
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $reviews[] = $row;
        }
        return json_encode($reviews);
    }
    $mysqli->close();

}

function displayFavMovie($newUser){


    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }


    $result = $mysqli->query("SELECT * FROM favoriteMovies WHERE username = '$newUser'");
    $favs = array();
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $favs[] = $row;
        }
        return json_encode($favs);
    }
    $mysqli->close();
}

function registerMessage($username, $hash){


    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
    if($result->num_rows > 0){
        $mysqli->close();
        return false;
    }
    else{

        if (!$mysqli -> query("INSERT INTO users (username,password) VALUES ('$username', '$hash')")) {
            echo("Error description: " . $mysqli -> error);
        }
        $mysqli->close();
        echo "account being created";
        return true;




    }



}


function request_processor($req){
    echo "Received Request".PHP_EOL;
    echo "<pre>" . var_dump($req) . "</pre>";
    if(!isset($req['type'])){
        return "Error: unsupported message type";
    }
    //Handle message type
    $type = $req['type'];
    switch($type){
        case "displayReview":
            return displayReviews($req['newUser']);
        case "displayFav":
            return displayFavMovie($req['newUser']);
        case "review":
            return movieReviewMessage($req['newUser'], $req['review']);
        case "favMovie":
            return movieFavMessage($req['newUser'], $req['movieText']);
        case "login":
            return loginMessage($req['username'], $req['password']);
        case "register":
            return registerMessage($req['username'], $req['hash']);
        case "validate_session":
            return validate($req['session_id']);
        case "echo":
            return array("return_code"=>'0', "message"=>"Echo: " .$req["message"]);
    }
    return array("return_code" => '0',
        "message" => "Server received request and processed it");
}

$server = new rabbitMQServer("testRabbitMQ.ini", "sampleServer");

echo "Rabbit MQ Server Start" . PHP_EOL;
$server->process_requests('request_processor');
echo "Rabbit MQ Server Stop" . PHP_EOL;
exit();

?>
