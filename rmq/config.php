<?php
$db = new PDO('sqlite:it490.sqlite');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>