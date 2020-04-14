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
    $mysqli = new mysqli($host,$user,$pass,$db); //object oriented mysqli

    if ($mysqli->connect_error){
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
		$userSes = array("name"=> $user['username']);
		echo "logging in";
		return json_encode($userSes);
	}
	else {
	    $mysqli->close();
	    echo "account does not exist or the username/password are incorrect";
	    return false;
    }
}	//needed $mysqli-close() in every if/else in order to properly close connection

function registerMessage($username, $hash){ 

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db); //object oriented mysqli

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

	$result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
	if($result->num_rows > 0){  //if there is a row then an accoutn is already made
	    $mysqli->close();
		return false;
	}
	else{

		if(!$mysqli->query("INSERT INTO users (username, password) VALUES ('$username', '$hash')")){
            echo("Error Description: " . $mysqli->error); //adding this error checking is the only was the data was put in the DB
        }
		$mysqli->close();
		echo "account being created";
        return true;
	}

}

function movieFavMessage($newUser, $movieText){
	
    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "INSERT INTO favoriteMovies (username, movieText) VALUES ('$newUser', '$movieText')";

    if ($mysqli->query($sql)==TRUE){
        echo "Record created successfully";


    }
    else{

        echo "ERROR: " .$sql. "<br>" .$mysqli->error;

    }

    $mysqli->close();


	
	
	
}

function displayFavMovie($newUser){


    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }


    $result = $mysqli->query("SELECT * FROM favoriteMovies WHERE username = '$newUser'");
    $favs = array();
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $favs[] = $row;
        }
        return json_encode($favs);
    }
    $mysqli->close();
}

function apiRequest($api){
    
    $curl = curl_init();

    curl_setopt_array($curl, array(CURLOPT_URL => "https://imdb-internet-movie-database-unofficial.p.rapidapi.com/search/$api",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "x-rapidapi-host: imdb-internet-movie-database-unofficial.p.rapidapi.com",
            "x-rapidapi-key: d06d55bac0msh0005fcfba20f964p1ddd4cjsndc27523d1d46",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $result = json_encode($response);

    curl_close($curl);

    return $result;

   // if ($err) {
     //   echo "cURL Error #:" . $err;
  //  } else {
   //     echo $result;
  //  }


}

function displayReviews($newUser){

    $host = 'localhost';
    $user = 'mark';
    $pass = 'markit';
    $db = 'new490';
    $mysqli = new mysqli($host,$user,$pass,$db);

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT * FROM reviews WHERE username = '$newUser'");
    $reviews = array();
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $reviews[] = $row;
        }
        return json_encode($reviews);
    }
    $mysqli->close();

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
		case "apirequest":
           		 return apirequest($req['api']);
		case "displayReview":
           		 return displayReviews($req['newUser']);
        	case "displayFav":
           		 return displayFavMovie($req['newUser']);
		case "favMovie":
            		return movieFavMessage($req['newUser'], $req['movieText']);
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
