<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require("config.php");
$conn_string = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

function loginMessage($username, $password){
	global $conn_string;
	global $userDB, $passDB;


	$db = new PDO($conn_string, $userDB, $passDB);
	$stmt = $db->prepare("select id, username, password from `Users` where username = :username LIMIT 1");
	$usernp = array(":username"=>$username);
	$stmt->execute($usernp);
	$results = $stmt->fetch(PDO::FETCH_ASSOC);

	if(password_verify($password, $results['password'])){ //comparing plaintext and hash
		$stmt->execute(array(":username"=> $username));
		if($results && count($results) > 0){
			$userSes = array("name"=> $results['username']);
			return json_encode($userSes);
		}
		return true;
		echo "Logged in (Console)";
	}
	else{
		echo "invalid password";
	}
}

function registerMessage($username, $hash){
	global $conn_string;
	global $userDB, $passDB;
	$db = new PDO($conn_string, $userDB, $passDB);

	//checking if username exists already
	$usncheck = $db->prepare("SELECT * FROM `Users` where username = :username");
	$usernp = array(":username"=>$username);
	$usncheck->execute($usernp);
	$results = $usncheck->fetch(PDO::FETCH_ASSOC);
	if($results && count($results) > 0){
		echo "Username already exists";
		return false;
	}
	//check passed, inserts user
	$stmt = $db->prepare("INSERT into `Users` (`username`, `password`) VALUES(:username, :password)");
	$r = $stmt->execute(array(":username"=> $username, ":password"=> $hash));
}

function apirequest($search){
        require("config.inc");
        $curl = curl_init();

curl_setopt_array($curl, array(CURLOPT_URL => "https://imdb-internet-movie-database-unofficial.p.rapidapi.com/?page=1&r=json&s=$search",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
                "x-rapidapi-host: imdb-internet-movie-database-unofficial.p.rapidapi.com",
                "x-rapidapi-key: d06d55bac0msh0005fcfba20f964p1ddd4cjsndc27523d1d46"
        ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
        echo "cURL Error #:" . $err;
} else {
        echo $response;
}
}

function request_processor($req){
	echo "Received Request".PHP_EOL;
	echo "<pre>" . var_dump($req) . "</pre>";
	if(!isset($req['type'])){
		return "Error: unsupported message type";
	}
	//Handle message type
	$type = $req['type']; //takes messsage array and puts it into req[]
	switch($type){
		case "login":
			return loginMessage($req['username'], $req['password']);
		case "register":
			return registerMessage($req['username'], $req['hash']);
		case "validate_session":
			return validate($req['session_id']);
		case "apirequest":
			return apirequest($req['query']);
		case "echo": //DONT NEED
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
