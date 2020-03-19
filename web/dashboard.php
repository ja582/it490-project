<?php
session_start();

if($_SESSION['logged'] = true){
    echo 'session detected';
    echo '<br>';
    echo 'hello'.$_SESSION['username'].'how are you today?';
}else{
    echo 'nope, no session detected!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dashboard</title>
</head>
<body>
the
</body>
</html>
