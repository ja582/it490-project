<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require('dbCon.php');


function loginMessage($username,$password){

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
		echo "logging in";
		return true;
	}
	else {
	    $mysqli->close();
	    echo "account does not exist or the username/password are incorrect";
	    return false;
    }
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

		if(!$mysqli->query("INSERT INTO users (username, password) VALUES ('$username', '$hash')")){
            echo("Error Description: " . $mysqli->error);
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
