<?php
require('/var/www/html/it490-project/rmq/RabbitMQClient.php');

if(isset($_POST['submitButton'])){
    try{
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username != "" && $password != "" ){
            $rabbitResponse = login($username, $password);
            if($rabbitResponse==false){
                echo "login has failed, please try again";
                //redirect back to login page to try again
            }else{
                echo "You are logged in!";
                //redirect to homepage or profile page???
            }
        }
        else{
            echo "username and password is empty";
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<form class="form-signin" method="POST" action="#">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <input name="username" type="text" class="form-control" placeholder="Username" required autofocus/>
    <input name="password" type="password" class="form-control" placeholder="Password" required/>
    <input type="submit" value="Submit" name="submitButton" id="submitButton"/>
</form>
</body>
</html>
