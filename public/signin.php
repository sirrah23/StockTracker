<?php

require("../common/header.php");

//Define variables
$username = $_POST["username"];
$password = $_POST["password"];

$host = '127.0.0.1';
$db   = 'StockTracker';
$user = 'root';
$pass = 'password';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $opt);
//TODO:Do a prepared statement here
$stmt = $pdo->query('SELECT * FROM Users');

//Test
echo("<div id='content'>");
echo("Your username is ".$username."</br>");
echo("Your password is ".$password."\n"."</br>");
echo("List of user ids and passwords:</br>");
while($row = $stmt->fetch()){
  echo($row['username']." ".$row['password']);
}
echo("</div>");

require("../common/footer.php");

?>
