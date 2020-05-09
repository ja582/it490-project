<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function apiRequest($api){

    $client = new RabbitMQClient('apiRabbitMQ.ini', 'testServer');
    if(isset($argv[1])){
        $msg = $argv[1];
    }
    else{
        $msg = array("message"=>"API Request", "type"=>"api_send",  "api" => $api);
    }

    $response = $client->send_request($msg);

    //echo "client received response: " . PHP_EOL;
    return($response);
    //echo "\n\n";

    if(isset($argv[0]))
        echo $argv[0] . " END".PHP_EOL;
}
?>

