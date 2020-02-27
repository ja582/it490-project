<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('db/dbCon.php');


function loginMessage($username,$password){
	
	//TODO validate user credentials
	//new branch

	$result = $mysqli->query("SELECT * FROM users WHERE username='$username' and password='$password'");
	$user = $result->fetch_assoc();

	if($result->num_rows == 0 ){ //0 meaning that a row was not found with the username and password
		echo "account does not exist";
		return false;
	}
	else{ //row was found in the table, meaning an account exists
		echo "You're logged in";
		return true;


	}



	
}

function registerMessage($username, $password){

	$result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
	if($result->num_rows > 0){
		return false;
	}
	else{

		$sql = "INSERT INTO users (username, password) VALUES ($username, $password)";
		$mysqli->query($sql);

		echo "Thank you. Account created";
		


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
