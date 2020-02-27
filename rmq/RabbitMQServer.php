<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once(dbCon.php);


function loginMessage($username,$password){
	
	//TODO validate user credentials
	
	return true; //return true meaning that credentials match
	
	
}

function registerMessage($uername, $password){
	//need to see if username already exists (check rows)
	$result = $mysqli->query("SELECT * FROM users WHERE username='$username'");

	if ($result->num_rows > 0 ){
		return false; //returning false meaning that the username was found in the table
	}
	else{
		//add username and password into the table


	}


	

}


function request_processor($req){
	echo "Received Request".PHP_EOL;
	echo "<pre>" . var_dump($req) . "</pre>";
	if(!isset($req['type'])){
		return "Error: unsupported message type";
	}
	//Handle message type
	$type = $req['type']; //listening for type from an array called $req. need to make array $req in client (producer)
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
