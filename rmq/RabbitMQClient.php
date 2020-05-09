<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function registerMessage($username, $hash){
	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
	}
	else{
		$msg = array("message"=>"Register", "type"=>"register", "username" => $username, "hash" => $hash ); //added hash. server listens for "register" now for registering

	}



	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function loginMessage($username, $password){

	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Login", "type"=>"login", "username" => $username, "password" => $password);
		//server listens for "login" in processor function then points to login function
	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function createMovieMessage($movie_title, $score, $uid){

	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Movie", "type"=>"create_list", "movie_title" => $movie_title, "score" => $score, "uid" => $uid);
	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}
function displayMovieList($uid){

	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display List", "type"=>"display_list",  "uid" => $uid);
	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}
function echoMessage($echo){

	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Echo Message", "type"=>"echo_msg",  "echo" => $echo);
	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function apiWriteMessage($apiReq, $score, $uid){

	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"API Written", "type"=>"write_api",  "apiReq" => $apiReq, "score" => $score, "uid" => $uid);
	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;
}

function movieFavMessage($uid, $movieText){
	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Fav movie", "type"=>"favMovie", "uid" => $uid, "movieText" => $movieText);

	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;


}

function displayFavMovie($uid){
	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display Fav", "type"=>"displayFav", "uid" => $uid);

	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;


}

function displayReviews($uid){
	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display Review", "type"=>"displayReview", "uid" => $uid);

	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;


}

function displayApiDB($uid){
	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Display API", "type"=>"displayApi", "uid" => $uid);

	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;


}

function movieReviewMessage($uid, $review){

	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Review movie", "type"=>"review", "uid" => $uid, "review" => $review);

	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;

}

function listManagerDel($mid){
	$client = new RabbitMQClient('databaseRabbitMQ.ini', 'it490Server');
	if(isset($argv[1])){
		$msg = $argv[1];
	}
	else{
		$msg = array("message"=>"Movie Deleted!", "type"=>"delmovie", "mid" => $mid);

	}

	$response = $client->send_request($msg);

	//echo "client received response: " . PHP_EOL;
	return($response);
	//echo "\n\n";

	if(isset($argv[0]))
		echo $argv[0] . " END".PHP_EOL;

}
?>

