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
                echo "Logged in (Console)";
				return true;
			}
			else{
				echo "invalid password";
			}
}
/*
function loginMessage($username,$password){

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db); //object oriented mysqli

    if ($mysqli->connect_error){ //object oriented connection error
        die("Connection failed: " . $mysqli->connect_error);
    }
//-> is the object operator. allows variable to access methods of an object
	//$mysqli->query, $mysqli calling mysqli query method
	$result = $mysqli->query("SELECT * FROM users WHERE username='$username'"); //only looking for username now becuase password is hashed in DB
	
	
	$rowUsername = $result->fetch_assoc(); //need to fetch row to compare hash pass to plaintext pass
				//fetch_assoc() fetches a row as an associative array
	//$result calling sqli num_rows method
	if($result->num_rows == 0 || !password_verify($password, $rowUsername['password']) ){ //if there are now rows or the hash doesnt match the plaintext password
	//password_verify returns a bool.  
	//num_rows gets number of rows
	    $mysqli->close();
		echo "account does not exist or the username/password are incorrect";
		return false;
	}
	else if($result->num_rows !== 0 && password_verify($password, $rowUsername['password'])) { //row was found and hash matches plain text password
	    $mysqli->close();
		echo "logging in";
		return true;
	}
	else {
	    $mysqli->close();
	    echo "account does not exist or the username/password are incorrect";
	    return false;
    }
}	//needed $mysqli-close() in every if/else in order to properly close connection

*/
function registerMessage($username, $hash){

	global $host, $userDB, $passDB, $dbName;
    $mysqli = new mysqli($host,$userDB,$passDB,$dbName); //object oriented mysqli

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error); //object oriented connectiion error
    }

	$result = $mysqli->query("SELECT * FROM Users WHERE username='$username'");
	if($result->num_rows > 0){  //if there is a row then an accoutn is already made
	    $mysqli->close();
		return false;
	}
	else{

		if(!$mysqli->query("INSERT INTO Users (username, password) VALUES ('$username', '$hash')")){
            echo("Error Description: " . $mysqli->error); //adding this error checking is the only was the data was put in the DB
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
	$type = $req['type']; //takes messsage array and puts it into req[]
	switch($type){
		case "login":
			return loginMessage($req['username'], $req['password']);
		case "register":
			return registerMessage($req['username'], $req['hash']);
		case "validate_session":
			return validate($req['session_id']);
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
