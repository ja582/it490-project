<html>
<?php
//seperate file to space things out and allow pointing to other files. 
require("/var/www/html/it490-project/rmq/RabbitMQClient.php");
echo "random message";

$username = $_POST['username'];
$password = $_POST['password'];

$hash = password_hash($password, PASSWORD_BCRYPT); //hashing. 

$rabbitResponse = registerMessage($username,$hash); //registerMessage in RabbitMQClient.php. 
echo 'bye';

if($rabbitResponse==false){
    echo "account already created";
    //can redirect here to register page to try again. 

}else{

    echo "Account is created";
    //can redirect here to login page

}

//use this to also point to login.php after the user registers. Header()?????????



?>
</html>
