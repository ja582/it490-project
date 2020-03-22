<?php


session_start();
session_unset();
session_destroy();
?>

<head>
    <meta charset="UTF-8">
</head>

<body>
<div class="form">
    <h1><?= 'You have logged out'; ?></h1>
    <a href="login.php">login?</a>


</div>
</body>
</html>
