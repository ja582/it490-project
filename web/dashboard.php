<?php
session_start();

if($_SESSION['logged'] != true){
    echo 'not logged in';
}else{
    $un = $_SESSION['username'];
    if($un == null){
        echo "username session variable is empty";
    }else{
        echo "session not empty";
    }
    echo '<br>';
    echo 'hello '.$un.'. how are you today?';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dashboard</title>
</head>
<body>

</body>
</html>
