<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function registerMessage($username, $hash){
	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
	}
	else{
		$msg = array("message"=>"Register", "type"=>"register", "username" => $username, "hash" => $hash ); //added hash. server listens for "register" now for registering

	}



	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function loginMessage($username, $password){

	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Login", "type"=>"login", "username" => $username, "password" => $password);
		//server listens for "login" in processor function then points to login function
	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function createMovieMessage($movie_title, $score, $uid){

	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Movie", "type"=>"create_list", "movie_title" => $movie_title, "score" => $score, "uid" => $uid);
	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}
function displayMovieList($uid){

	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display List", "type"=>"display_list",  "uid" => $uid);
	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}
function echoMessage($echo){

	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Echo Message", "type"=>"echo_msg",  "echo" => $echo);
	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function apiRequest($api){

	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"API Request", "type"=>"api_send",  "api" => $api);
	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}
?>

