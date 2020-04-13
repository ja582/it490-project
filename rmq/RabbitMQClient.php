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

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
if(isset($argv[1])){
	$msg = array("query"=>$argv[1], "type"=>"apirequest");
} else{
	$msg = array("query"=>"hero", "type"=>"apirequest");
}

$response = $client->send_request($msg);

echo "Info you asked for: " . PHP_EOL;
print_r($response);

if(isset($argv[0]))
	echo $argv[0] . " END" . PHP_EOL;

?>

