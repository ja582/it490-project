<?php
//The header here includes all the html code, session, and the navbar. Just including this will make new pages way easier to create.
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$un = $_SESSION['user']['name'];
$id = $_SESSION['user']['id'];
if($_SESSION['logged'] != true){
    header("Location: login.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/grid/">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="theme-color" content="#563d7c">
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
    <link href="grid.css" rel="stylesheet">
</head>
<body class="py-4">
<div class="container">
    Welcome <?php echo $un ?>! User ID: <?php echo $id ?>
    <br>
    <a href="dashboard.php">Home</a> /  <a href="profile.php">Profile</a> / <a href="apiSearch.php">Add to Movie List</a> / <a href="movieReview.php">Create a Review</a> / <a href="moviedb.php">View Movie Database</a> / <a href="logout.php">Logout</a>
    <br>
