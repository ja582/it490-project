<?php
include_once("blade/header.php");

$response = displayMovieList($id);
if($response == false){
    echo "Response is false!";
}

$list = json_decode($response, true);
?>

    <head>
        <title>User Profile</title>
        <link rel="stylesheet" href="css/profileStyle.css">
    </head>
    <div class="leftpane">
        <h1>Favorite Movies</h1>
        <input type='text' id='idea' />
        <input type='button' value='add to list' id='add' />
        <script>
            document.getElementById("add").onclick  = function() {
                var node = document.createElement("Li");
                var text = document.getElementById("idea").value;
                var textnode=document.createTextNode(text);
                node.appendChild(textnode);
                document.getElementById("list").appendChild(node);
                document.getElementById('idea').value=null;

            }
        </script>
        <ul id='list'></ul>
    </div>
    <div class="middlepane">
        <h1>Movie Lists<h1>

    </div>
    <div class="rightpane">
        <h1>Movie Reviews</h1></div>
    </div>

<?php
include_once("blade/footer.php");
?>
