<?php

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://movie-database-imdb-alternative.p.rapidapi.com/?page=1&r=json&s=guardians%20of%20the%20galaxy",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"x-rapidapi-host: movie-database-imdb-alternative.p.rapidapi.com",
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

?>

</head>
<body>
  <form action="" method="get">
            <label for="query">Enter your query string:</label>
            <input id="query" type="text" name="query" />
            <br />
            <button type="submit" name="submit">Search</button>
  </form>
  <br />
  <?php
  if (!empty($news)) {
            echo '<b>Info about your movie:</b>';
            foreach ($news as $post) {
                   echo '<h3>' . $post['title'] . '</h3>';
                   echo '<a href="' . $post['url'] . '">Source</a>';
                   echo '<p>Date Published: ' . $post['datePublished'] . '</p>';
                   echo '<p>' . $post['body'] .'</p>';
                   echo '<hr>';
            }
  }
  ?>
</body>
</html>
