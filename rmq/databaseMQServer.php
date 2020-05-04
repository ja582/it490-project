<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once("config.php");


function loginMessage($username, $password){
	global $db;

	$stmt = $db->prepare('SELECT id, username, password FROM Users WHERE username = :username LIMIT 1');
	$stmt->bindParam(':username', $username);
	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);

	if($results){
		$userpass = $results['password'];
		if(password_verify($password, $userpass)){ //comparing plaintext and hash
			$stmt->bindParam(':username', $username);
			$stmt->execute();
			if($results && count($results) > 0){
				$userSes = array("name"=> $results['username'], "id"=> $results['id']);
				return json_encode($userSes);
			}
			return true;
			echo "Logged in (Console)";
		}
		else{
			return false;
			echo "invalid password";
		}
	}
}

function registerMessage($username, $hash){
	global $db;

	//checking if username exists already
	$usncheck = $db->prepare('SELECT * FROM Users where username = :username');
	$usncheck->bindParam(':username', $username);
	$usncheck->execute();
	$results = $usncheck->fetch(PDO::FETCH_ASSOC);
	if($results && count($results) > 0){
		echo "Username already exists";
		return false;
	}
	//check passed, inserts user
	$quest = 'INSERT INTO Users (username, password) VALUES (:username, :password)';
	$stmt = $db->prepare($quest);
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $hash);
	$stmt->execute();
}

function createMovieMessage($movie_title, $score, $uid){
	global $db;

	$quest = 'INSERT INTO user_movies (movie_title, score, user_id) VALUES (:movie_title, :score, :user_id)';
	$stmt = $db->prepare($quest);
	$stmt->bindParam(':movie_title', $movie_title);
	$stmt->bindParam(':score', $score);
	$stmt->bindParam(':user_id', $uid);
	$stmt->execute();
}

function displayMovieList($uid){
	global $db;

	$quest = 'SELECT * FROM user_movies WHERE user_id = (:user_id)';
	$stmt = $db->prepare($quest);
	$stmt->bindParam(':user_id', $uid);
	$stmt->execute();
	$results = $stmt->fetchAll();

	return json_encode($results);
}

function movieReviewMessage($uid, $review){
	global $db;

	$quest = 'INSERT INTO user_reviews (review, user_id) VALUES (:review, :user_id)';
	$stmt = $db->prepare($quest);
	$stmt->bindParam(':review', $review);
	$stmt->bindParam(':user_id', $uid);
	$stmt->execute();
}

function displayReviews($uid){
	global $db;

	$quest = 'SELECT * FROM user_reviews WHERE user_id = (:user_id)';
	$stmt = $db->prepare($quest);
	$stmt->bindParam(':user_id', $uid);
	$stmt->execute();
	$reviews = $stmt->fetchAll();

	return json_encode($reviews);
}

function displayFavMovie($uid){
	global $db;

	$quest = 'SELECT * FROM user_movies WHERE user_id = (:user_id) LIMIT 10';
	$stmt = $db->prepare($quest);
	$stmt->bindParam(':user_id', $uid);
	$stmt->execute();
	$favs = $stmt->fetchAll();

	return json_encode($favs);
}

function apiWriteMessage($apiReq, $score, $uid){
	global $db;

	if($score && $uid == null){
		echo "Score and User ID is null!";
		echo "\n\n";
		return false;
	}
	echo "Received the API request";
	echo "\n\n";
	$recAPI = json_decode($apiReq, true);
	if($recAPI == null){
		//Checks if API is null (Happened sometimes when testing)
		echo "API Request is null!";
		echo "\n\n";
		return false;
	}else{
		//Looping to go through each movie in the JSON Array
		if(is_array($recAPI)){
			//Setting variables for later insertion
			$title = $recAPI["title"];
			$img = $recAPI["poster"];
			$mid = $recAPI["id"];
			$intYear = intval($recAPI["year"]);
			$plot = $recAPI["plot"];
			$length = $recAPI["length"];
			$intRating = intval($recAPI["rating"]);
			//Checking if movie is already in movies table
			$moviecheck = $db->prepare('SELECT * FROM movies where title = :title');
			$moviecheck->bindParam(':title', $title);
			$moviecheck->execute();
			$results = $moviecheck->fetch(PDO::FETCH_ASSOC);
			if($results && count($results) > 0){
				//Movie already exists, but will write into list nonetheless
				echo "Movie already exists in database.. adding it to user's list.";
				echo "\n\n";
				$quest = 'INSERT INTO user_movies (movie_title, score, user_id) VALUES (:movie_title, :score, :user_id)';
				$stmt = $db->prepare($quest);
				$stmt->bindParam(':movie_title', $title);
				$stmt->bindParam(':score', $score);
				$stmt->bindParam(':user_id', $uid);
				$stmt->execute();
				echo "Inserted the movie '".$title."' into user #".$uid." list!";
				echo "\n\n";
				return true;
			}else{
				//Inserts called movies into DB
				$quest = 'INSERT INTO movies (title, year, length, rating, plot, poster, imdb_id) VALUES (:title, :year, :length, :rating, :plot, :poster, :imdb_id)';
				$stmt = $db->prepare($quest);
				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':year', $intYear);
				$stmt->bindParam(':length', $length);
				$stmt->bindParam(':rating', $intRating);
				$stmt->bindParam(':plot', $plot);
				$stmt->bindParam(':poster', $img);
				$stmt->bindParam(':imdb_id', $mid);
				$stmt->execute();
				//Title has been inserted
				echo "Inserted the movie '".$title."'!";
				echo "\n\n";
				//Inserting movie into User's list
				createMovieMessage($title, $score, $uid);
				echo "Inserted the movie '".$title."' into user #".$uid." list!";
				echo "\n\n";
				return true;
			}
		}
		else{
			echo "Error occurred!";
			echo "\n\n";
			return false;
		}
	}
}

function displayApiDB($uid){
	global $db;

	$quest = 'SELECT * FROM movies';
	$stmt = $db->prepare($quest);
	$stmt->execute();
	$apiList = $stmt->fetchAll();

	return json_encode($apiList);
}

function request_processor($req){
	echo "Received Request".PHP_EOL;
	echo "<pre>" . var_dump($req) . "</pre>";
	if(!isset($req['type'])){
		return "Error: unsupported message type";
	}
	//Handle message type
	$type = $req['type']; //takes message array and puts it into req[]
	echo "\n\n";
	echo $type;
	switch($type){
		case "login":
			return loginMessage($req['username'], $req['password']);
		case "register":
			return registerMessage($req['username'], $req['hash']);
		case "create_list":
			return createMovieMessage($req['movie_title'], $req['score'], $req['uid']);
		case "display_list":
			return displayMovieList($req['uid']);
		case "write_api":
			return apiWriteMessage($req['write_req'], $req['score'], $req['uid']);
		case "displayFav":
			return displayFavMovie($req['uid']);
		case "favMovie":
			return movieFavMessage($req['uid'], $req['movieText']);
		case "review":
			return movieReviewMessage($req['uid'], $req['review']);
		case "displayReview":
			return displayReviews($req['uid']);
		case "displayApi":
			return displayApiDB($req['uid']);
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
