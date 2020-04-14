<?php                                                                                                               
//file used to connect to database

$host = "192.168.1.51;                                                                                                  
$user = "root";                                                                                                         
$pass = "markit";                                                                                                       
$database = "it490";                                                                                                    

$link=mysqli_connect ($host,$user,$pass,$database);                                                                     

if (mysqli_connect_error()){
  die("Database Connection failed: ".mysqli_connect_error());
        }                                                                                                               
        
?>
