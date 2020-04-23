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

function echoWriteMessage($write){
	global $db;
	echo "Received the echo.";
	$toWrite = json_decode($write, true);
	echo "To write: ".$toWrite;
	if($toWrite == null){
		echo "Message to write is null!";
		exit;
	}else{
		$quest = 'INSERT INTO letters (content) VALUES (:content)';
		$stmt = $db->prepare($quest);
		$stmt->bindParam(':content', $toWrite);
		$stmt->execute();
		echo "Wrote the echo";
	}

}

function apiWriteMessage($apiReq){
	global $db;

	echo "Received the API request";
	$toWriteAPI = json_decode($apiReq, true);
	if($toWriteAPI == null){
		echo "API is null!";
	}else{
		echo "To write: ".$toWriteAPI;
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
	echo $type;
	switch($type){
		case "login":
			return loginMessage($req['username'], $req['password']);
		case "register":
			return registerMessage($req['username'], $req['hash']);
		case "create_list":
			return createMovieMessage($req['movie_title'], $req['score'], $req['uid']);
		case "display_list":
			return displayMovieList($req['uid']);
		case "write_message":
			return echoWriteMessage($req['wrt']);
		case "write_api":
			return apiWriteMessage($req['write_req']);	}
	return array("return_code" => '0',
		"message" => "Server received request and processed it");
}

$server = new rabbitMQServer("testRabbitMQ.ini", "sampleServer");

echo "Rabbit MQ Server Start" . PHP_EOL;
$server->process_requests('request_processor');
echo "Rabbit MQ Server Stop" . PHP_EOL;
exit();

?>
