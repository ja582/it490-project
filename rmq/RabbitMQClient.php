<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function registerMessage($username, $hash){
$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
if(isset($argv[1])){
	$msg = $argv[1];
}
else{
	$msg = array("message"=>"Register", "type"=>"register", "username" => $username, "hash" => $hash ); //goign to have to change this to a different type (
	
}
//going have to write how the clinet handles the username and passwrod
//probably using some sort of array 

$response = $client->send_request($msg);

echo "client received response: " . PHP_EOL;
return($response);
echo "\n\n";

if(isset($argv[0]))
echo $argv[0] . " END".PHP_EOL;
}

function movieFavMessage($newUser,$movieText){
	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Fav movie", "type"=>"favMovie", "newUser" => $newUser, "movieText" => $movieText );

	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;


}

function movieReviewMessage($newUser, $review){

	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Review movie", "type"=>"review", "newUser" => $newUser, "review" => $review );

	}

	$response = $client->send_request($msg);

	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;





}

function displayFavMovie($newUser){
	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display Fav", "type"=>"displayFav", "newUser" => $newUser);

	}

	$response = $client->send_request($msg);

//	echo "client received response: " . PHP_EOL;
	return($response);
	echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;


}

function displayReviews($newUser){
	$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display Review", "type"=>"displayReview", "newUser" => $newUser);

	}

	$response = $client->send_request($msg);

//	echo "client received response: " . PHP_EOL;
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
		$msg = array("message"=>"API Request", "type"=>"apiRequest", "api" => $api);

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
	$msg = array("message"=>"Login", "type"=>"login", "username" => $username, "password" => $password); //going to have to chnage this to different type (type "login")

}
//going have to write how the clinet handles the username and passwrod
//probably using some sort of array 
$response = $client->send_request($msg);

echo "client received response: " . PHP_EOL;
return($response);
echo "\n\n";

if(isset($argv[0]))
echo $argv[0] . " END".PHP_EOL;
}

?>
