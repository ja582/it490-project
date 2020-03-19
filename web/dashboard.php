<?php
session_start();

if($_SESSION['logged'] = true){
    echo 'session detected';
}else{
    echo 'nope';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dashboard</title>
</head>
<body>
dashboard
</body>
</html>
