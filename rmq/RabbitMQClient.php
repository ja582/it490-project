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
	$msg = "Register"; //message being assigned register
}
//going have to write how the clinet handles the username and passwrod
//probably using some sort of array

//fill an array? assign ['']="" or $req = array( "type" => "Register", ....)
//arrays in php are key value pairs


$req = array("type" => "register", "username" => $username, "password" => $password, "message" => $msg);


$response = $client->send_request($req);

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
	$msg = "Login"; //assigning message to login
	
}
//going have to write how the clinet handles the username and passwrod
//probably using some sort of array 

$req = array("type" => "login", "username" => $username, "password" => $password, "message" => $msg);

$response = $client->send_request($req);

echo "client received response: " . PHP_EOL;
return($response);
echo "\n\n";

if(isset($argv[0]))
echo $argv[0] . " END".PHP_EOL;
}

?>
