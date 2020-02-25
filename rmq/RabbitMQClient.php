<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function registerMessage($username, $password){
$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
if(isset($argv[1])){
	$msg = $argv[1];
}
else{
	$msg = array("message"=>"test message", "type"=>"echo"); //goign to have to change this to a different type (
	
}

$response = $client->send_request($msg);

echo "client received response: " . PHP_EOL;
print_r($response);
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
	$msg = array("message"=>"test message", "type"=>"echo"); //going to have to chnage this to different type (type "login")
	
}

$response = $client->send_request($msg);

echo "client received response: " . PHP_EOL;
print_r($response);
echo "\n\n";

if(isset($argv[0]))
echo $argv[0] . " END".PHP_EOL;
}

?>
