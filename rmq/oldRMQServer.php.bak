
<?php
/*
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require("config.php");
$conn_string = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";


function loginMessage($username,$password){

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db); //object oriented mysqli

    if ($mysqli->connect_error){ //object oriented connection error
        die("Connection failed: " . $mysqli->connect_error);
    }
//-> is the object operator. allows variable to access methods of an object
	//$mysqli->query, $mysqli calling mysqli query method
	$result = $mysqli->query("SELECT * FROM users WHERE username='$username'"); //only looking for username now becuase password is hashed in DB


	$rowUsername = $result->fetch_assoc(); //need to fetch row to compare hash pass to plaintext pass
				//fetch_assoc() fetches a row as an associative array
	//$result calling sqli num_rows method
	if($result->num_rows == 0 || !password_verify($password, $rowUsername['password']) ){ //if there are now rows or the hash doesnt match the plaintext password
	//password_verify returns a bool.
	//num_rows gets number of rows
	    $mysqli->close();
		echo "account does not exist or the username/password are incorrect";
		return false;
	}
	else if($result->num_rows !== 0 && password_verify($password, $rowUsername['password'])) { //row was found and hash matches plain text password
	    $mysqli->close();
		echo "logging in";
		return true;
	}
	else {
	    $mysqli->close();
	    echo "account does not exist or the username/password are incorrect";
	    return false;
    }
}	//needed $mysqli-close() in every if/else in order to properly close connection


function registerMessage($username, $hash){

	global $host, $userDB, $passDB, $dbName;
    $mysqli = new mysqli($host,$userDB,$passDB,$dbName); //object oriented mysqli

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error); //object oriented connectiion error
    }

	$result = $mysqli->query("SELECT * FROM Users WHERE username='$username'");
	if($result->num_rows > 0){  //if there is a row then an accoutn is already made
	    $mysqli->close();
		return false;
	}
	else{

		if(!$mysqli->query("INSERT INTO Users (username, password) VALUES ('$username', '$hash')")){
            echo("Error Description: " . $mysqli->error); //adding this error checking is the only was the data was put in the DB
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
    $type = $req['type']; //takes messsage array and puts it into req[]
    switch($type){
        case "login":
            return loginMessage($req['username'], $req['password']);
        case "register":
            return registerMessage($req['username'], $req['hash']);
        case "validate_session":
            return validate($req['session_id']);
        case "echo": //DONT NEED
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
//pdo mysql rmq
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once("config.php");


function loginMessage($username, $password){
    global $db;

    $stmt = $db->prepare('SELECT id, username, password FROM Users WHERE username = :username LIMIT 1');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if($results){
        $userpass = $results['password'];
        if(password_verify($password, $userpass)){ //comparing plaintext and hash
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            if($results && count($results) > 0){
                $userSes = array("name"=> $results['username'], "id"=> $results['id']);
                return json_encode($userSes);
            }
            return true;
            echo "Logged in (Console)";
        }
        else{
            return false;
            echo "invalid password";
        }
    }
}

function registerMessage($username, $hash){
    global $db;

    //checking if username exists already
    $usncheck = $db->prepare('SELECT * FROM Users where username = :username');
    $usncheck->bindParam(':username', $username);
    $usncheck->execute();
    $results = $usncheck->fetch(PDO::FETCH_ASSOC);
    if($results && count($results) > 0){
        echo "Username already exists";
        return false;
    }
    //check passed, inserts user
    $quest = 'INSERT INTO Users (username, password) VALUES (:username, :password)';
    $stmt = $db->prepare($quest);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hash);
    $stmt->execute();
}

function createMovieMessage($movie_title, $score, $uid){
    global $db;

    $quest = 'INSERT INTO user_movies (movie_title, score, user_id) VALUES (:movie_title, :score, :user_id)';
    $stmt = $db->prepare($quest);
    $stmt->bindParam(':movie_title', $movie_title);
    $stmt->bindParam(':score', $score);
    $stmt->bindParam(':user_id', $uid);
    $stmt->execute();
}

function displayMovieList($uid){
    global $db;

    $quest = 'SELECT * FROM user_movies WHERE user_id = (:user_id)';
    $stmt = $db->prepare($quest);
    $stmt->bindParam(':user_id', $uid);
    $stmt->execute();
    $results = $stmt->fetchAll();

    return json_encode($results);
}

function request_processor($req){
    echo "Received Request".PHP_EOL;
    echo "<pre>" . var_dump($req) . "</pre>";
    if(!isset($req['type'])){
        return "Error: unsupported message type";
    }
    //Handle message type
    $type = $req['type']; //takes messsage array and puts it into req[]
    switch($type){
        case "login":
            return loginMessage($req['username'], $req['password']);
        case "register":
            return registerMessage($req['username'], $req['hash']);
        case "create_list":
            return createMovieMessage($req['movie_title'], $req['score'], $req['uid']);
        case "display_list":
            return displayMovieList($req['uid']);
        case "echo": //DONT NEED
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
*/
?>
