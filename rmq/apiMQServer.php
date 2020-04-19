<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require('apiMQClient.php');

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
    switch($type){
        case "echo_msg":
            return echoMessage($req['echo']);
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
