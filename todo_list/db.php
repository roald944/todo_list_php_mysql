<?php 

$localhost = "localhost";
$dbname = "test";
$user = "root";
$pass = "";

$dsn = 'mysql:localhost=' . $localhost . ';dbname=' . $dbname;

$pdo = new PDO($dsn, $user, $pass);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


?>