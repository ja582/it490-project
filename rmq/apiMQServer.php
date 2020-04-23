<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require('/home/joeapi/apiproject/rmq/apiClient.php');

function apiRequest($apiReq){
    $curl = curl_init();

    curl_setopt_array($curl, array(CURLOPT_URL => "https://imdb-internet-movie-database-unofficial.p.rapidapi.com/search/$apiReq",
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
    apiWriteMessage($result);

    curl_close($curl);

    echo "Encoding API";
}

function echoMessage($echo){
    echo "Testing for echo..";
    echo "Echo: ".$echo;
    echo "Decoded Echo";
    $out = json_encode($echo);
    echoWriteMessage($out);
    echo "Encoding echo";
}

function request_processor($req){
    echo "Received Request".PHP_EOL;
    echo "<pre>" . var_dump($req) . "</pre>";
    if(!isset($req['type'])){
        return "Error: unsupported message type";
    }
    //Handle message type
    $type = $req['type'];
    echo $type;
    switch($type){
        case "echo_msg":
            return echoMessage($req['echo']);
        case "api_send":
            return apiRequest($req['api']);
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
