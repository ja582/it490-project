<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('api_host_info.inc');
require_once('rabbitMQLib.inc');


function apiRequest($apiReq){
    //Checks the User's input for spaces and any other special characters, so it maybe properly inserted.
    if (strpos($apiReq, ' ') == true) {
        $nApiReq = str_replace(" ", "%2520", $apiReq);
    }else{
        $nApiReq = $apiReq;
    }
    //Check passed, going to api
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://imdb-internet-movie-database-unofficial.p.rapidapi.com/film/$nApiReq",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "x-rapidapi-host: imdb-internet-movie-database-unofficial.p.rapidapi.com",
            "x-rapidapi-key: 5f2818331bmshceba3faa9bcb533p18e145jsned421065d22a"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    if($response == null){
        echo "API is null!";
        echo "\n\n";
        echo "response var dump";
        echo "\n\n";
        echo var_dump($response);
        return false;
    }else{
        echo "\n\n";
        echo "API is not null - Sending it over to databaseMQ!";
        echo "\n\n";
        echo var_dump($response);
        return $response;
    }

}

function request_processor($req){
    echo "Received Request".PHP_EOL;
    echo "\n\n";
    echo "<pre>" . var_dump($req) . "</pre>";
    echo "\n\n";
    if(!isset($req['type'])){
        return "Error: unsupported message type";
    }
    //Handle message type
    $type = $req['type'];
    echo "\n\n";
    echo $type;
    switch($type){
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
