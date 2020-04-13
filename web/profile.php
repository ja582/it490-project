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
    <style>
        .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px;}
        .hideReview { position:absolute; top:-1px; left:-1px; width:1px; height:1px;}
        .home{right:200px;}
    </style>
</head>

<body>

<div class="container">
    <div class="toppane">
        <h1>Profile Details</h1>
        <p> <?php echo 'Welcome ' . $newUser ?> </p>
        <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
        <a href="homeSearch.php"><button class="home" name="home"/>Search Movies</button></a>
    </div>
    <div class="leftpane">
        <h1>Favorite Movies</h1>
        <form action="displayFavMoviesHandler.php" method="POST">
        <input type="submit" value = "View all your favorite movies" id="favsRev" name = "favsRev" />
        </form>
        <br>
        <br>
        <iframe name=hiddenFrame" class="hide"></iframe>
            <form action="favHandler.php" method="post" target="hiddenFrame">
        <input type='text' id='movieText' name="movieText" />
        <input type='submit' value='add to favorite movies' id='submit' name="submit" />
            </form>
        <script>
            document.getElementById("submit").onclick  = function() {
                var node = document.createElement("Li");
                var text = document.getElementById("movieText").value;
                var textnode=document.createTextNode(text);
                node.appendChild(textnode);
                document.getElementById("list").appendChild(node);
                //document.getElementById('idea').value=null;

            }
        </script>
        <ul id='list'></ul>

    </div>
    <div class="middlepane">
        <h1>Movie Lists</h1>

    </div>
    <div class="rightpane">
        <h1>Movie Reviews</h1>
        <form action="displayReviewsHandler.php" method="POST">
        <input type="submit" value="View all your movie reviews" id="revBut" name = "revBut" />
        </form>
        <br>
        <br>
        <iframe name=hiddenFrameReview" class="hideReview"></iframe>
        <form action="reviewHandler.php" method="post" target="hiddenFrameReview">
    <input type='text' id='review' name="review" placeholder="Movie Title - Review"/>
    <input type='submit' value='add to list' id='addList' />
        </form>
    <script>
        document.getElementById("addList").onclick  = function() {
            var nodeList = document.createElement("Li");
            var textList = document.getElementById("review").value;
            var textnodeList=document.createTextNode(textList);
            nodeList.appendChild(textnodeList);
            document.getElementById("reviewList").appendChild(nodeList);
            //document.getElementById('review').value=null;

        }
    </script>
    <ul id='reviewList'></ul>

</div>

</div>

</body>
</html>
