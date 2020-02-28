<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require('dbCon.php');


function loginMessage($username,$password){
	
	//TODO validate user credentials
	//new branch

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'it490';
    $mysqli = mysqli_connect($host,$user,$pass,$db);

    if (mysqli_connect_error()){
        die("Database Connection failed: ".mysqli_connect_error());
    }

	$result = $mysqli->query("SELECT * FROM users WHERE username='$username' and password='$password'");
	$user = $result->fetch_assoc();

	if($result->num_rows == 0 ){ //0 meaning that a row was not found with the username and password
		echo "account does not exist or the username/password are incorrect";
		return false;
	}
	else{ //row was found in the table, meaning an account exists
		echo "logging in";
		return true;



	}



	
}

function registerMessage($username, $password){


    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'it490';
    $mysqli = mysqli_connect($host,$user,$pass,$db);

    if (mysqli_connect_error()){
        die("Database Connection failed: ".mysqli_connect_error());
    }

	$result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
	if($result->num_rows > 0){
		return false;
	}
	else{

		$sql = "INSERT INTO users (username, password) VALUES ($username, $password)";
		$mysqli->query($sql);

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
		case "login":
			return loginMessage($req['username'], $req['password']);
		case "register":
			return registerMessage($req['username'], $req['password']);
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