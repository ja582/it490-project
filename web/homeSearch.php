
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
        <link href="homeStyle.css" rel="stylesheet">
    </head>

    <body>

    <div class="header">
        
            <h1> Search for movies and actors</h1>
            <div class="form-box">
                <form action="apiRequestHandler.php" method="POST">
                <input type="text" class="search-field movie" id="api" name="api" placeholder="movie, actor, ..">
                <button class="search-btn" type="submit">Search</button>

                </form>
            </div>



        


        <a href="profile.php"><button class="profile" name="profile"/>Return to profile</button></a>
    </div>




    </body>








</html>
