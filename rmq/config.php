<?php
$db = new PDO('sqlite:db490.sqlite');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query =   "CREATE TABLE IF NOT EXISTS Users(id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, password TEXT); 
            CREATE TABLE IF NOT EXISTS movies(id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, year INTEGER, length TEXT, rating INTEGER, plot TEXT, poster TEXT, imdb_id TEXT); 
            CREATE TABLE IF NOT EXISTS user_movies(id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, movie_title TEXT, score INTEGER, FOREIGN KEY(user_id) REFERENCES Users(id)); 
            CREATE TABLE IF NOT EXISTS favorite_movies(id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, movie_title TEXT, FOREIGN KEY(user_id) REFERENCES Users(id)); 
            CREATE TABLE IF NOT EXISTS user_reviews(id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, review TEXT, movie_id TEXT, FOREIGN KEY(user_id) REFERENCES Users(id), FOREIGN KEY(movie_title) REFERENCES movies(id))";

$db->exec($query);

?>
