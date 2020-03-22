<?php
session_start();

if ($_SESSION['logged'] != true){
    echo "not logged in";
}
else{
    $newUser = $_SESSION['user']['name'];
}
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="profileStyle.css">
</head>

<body>

<div class="container">
    <div class="toppane">
      <h1>Profile Details</h1>
      <p> <?php echo 'welcome' . $newUser ?> </p>
      <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
    </div>
    <div class="leftpane">
      <h1>Favorite Movies</h1>
    </div>
    <div class="middlepane">
      <h1>Movie Lists<h1>

    </div>
    <div class="rightpane">
      <h1>Movie Reviews</h1></div>
    </div>
</div>

</body>
</html>
