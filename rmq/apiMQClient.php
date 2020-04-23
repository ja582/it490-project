<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function apiWriteMessage($api){

    $client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
    if(isset($argv[1])){
        $msg = $argv[1];
    }
    else{
        $msg = array("message"=>"Writing API", "type"=>"write_api",  "write_req" => $api);
    }

    $response = $client->send_request($msg);

    echo "client received response: " . PHP_EOL;
    return($response);
    echo "\n\n";

    if(isset($argv[0]))
        echo $argv[0] . " END".PHP_EOL;
}

function echoWriteMessage($echo){

    $client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');
    if(isset($argv[1])){
        $msg = $argv[1];
    }
    else{
        $msg = array("message"=>"Writing Echo", "type"=>"write_message",  "wrt" => $echo);
    }

    $response = $client->send_request($msg);

    echo "client received response: " . PHP_EOL;
    return($response);
    echo "\n\n";

    if(isset($argv[0]))
        echo $argv[0] . " END".PHP_EOL;
}
?>

