<?php
// imdb api url
$url = "https://movie-database-imdb-alternative.p.rapidapi.com/";

//object being created that will be sent to the server to create a collection

$data = [
    'collection' => 'RapidAPI'
];

//creating new curl session

$curl = curl_init($url);

//setting the CURLOPT_RETURNTRANSFER option to true. allows the method to return the answer as a string
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//setting the CURLOPT_POST option to true for POST request
curl_setopt($curl, CURLOPT_POST, true);

curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

//creating cusomer headers for RapidAPI and content header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
	'X-RAPIDAPI-Host: movie-database-imdb-alternative.p.rapidapi.com',
	'X-RAPIDAPI-Key: d06d55bac0msh0005fcfba20f964p1ddd4cjsndc27523d1d46',
	'Content-Type: application/json'
]);

//executing cURL with info above
$response = curl_exec($curl);

//closing cURL session
curl_close($curl);

//displaying response from the sever
echo $response . PHP_EOL;




?>
