<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function apirequest($search){
        require("config.inc");
        $curl = curl_init();

curl_setopt_array($curl, array(CURLOPT_URL => "https://imdb-internet-movie-database-unofficial.p.rapidapi.com/search/$search",
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

if ($err) {
        echo "cURL Error #:" . $err;
} else {
        echo $result;
}
}

<<<<<<< HEAD
=======
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
>>>>>>> 4e9c24df825b0eb769a6f7e9e25344fd541f19fc

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
<<<<<<< HEAD
=======
		case "echo": //DONT NEED
			return array("return_code"=>'0', "message"=>"Echo: " .$req["message"]);
>>>>>>> 4e9c24df825b0eb769a6f7e9e25344fd541f19fc
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
