<?php


session_start();

if ($_SESSION['logged'] != true) {
    echo "not logged in";
} else {
    $newUser = $_SESSION['user']['name'];
}

require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

$response = displayReviews($newUser);

if ($response == false) {

    echo "ERROR";
    header("Location: profile.php");
} else {

    $reviews = json_decode($response, true);

    echo $reviews;
    
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";

    foreach($reviews as $review){
        echo $review['review'];
        echo "<br>";
        echo "<br>";
        echo "<br>";

    }

    echo "<br>";
    echo "<br>";

    echo "<a href='profile.php' >Return to Profile </a>";
}


?>
