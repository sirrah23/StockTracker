<?php

require("../common/header.php");

//TODO: Move database code to it's own function/object
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
$stmt = $pdo->prepare("SELECT * FROM Users WHERE username=? AND password=?");
$stmt->execute(array($username, $password));
$userdata = $stmt->fetchAll();

echo("<div id='contentreg'>");
if(sizeof($userdata) === 1){
  echo("Successfully logged in! </br>");
  //Store operating user in session state
  session_start();
  $_SESSION["userid"] = $userdata[0]["id"];
  $_SESSION["username"] = $username;
}else{
	echo("Bad username/password. Try again.");
}
echo("</div>");

require("../common/footer.php");

?>
