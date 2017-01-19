<?php 
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
?>

<?php
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

//Get the amount of cash in the account
$pdo = new PDO($dsn, $user, $pass, $opt);
$stmt = $pdo->prepare("SELECT amount FROM Cash JOIN Users ON Cash.user_id=Users.id WHERE Users.username=?");
$stmt->execute(array($_SESSION["username"]));
$cash_data = $stmt->fetchAll();

?>


<div id="portholder">
	<div class="tickbox">
	  <span class="ticker"> CASH </span>
	  <span class="amount"> <?php echo("$".$cash_data[0]["amount"]); ?> </span>
	</div>
</div>

<?php require("../common/footer.php"); ?>