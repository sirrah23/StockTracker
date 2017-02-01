<?php
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
?>

<?php
//Initialize
$username = $_SESSION["username"];
$user_id = $_SESSION["userid"];

//TODO: Move elsewhere
function get_cash_data($username){
	//TODO: Move DB Initialization elsewhere
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
	$stmt->execute(array($username));
	$cash_data = $stmt->fetchAll();
	return $cash_data;
}

//TODO: Move elsewhere
function get_stock_data($user_id){
	//TODO: Move DB Initialization elsewhere
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
	$stmt = $pdo->prepare("SELECT * FROM Stocks WHERE Stocks.user_id=?");
	$stmt->execute(array($user_id));
	$stock_data = $stmt->fetchAll();
	return $stock_data;
}

$cash_data = get_cash_data($username);
$stock_data = get_stock_data($user_id);

?>

<div id="lookup">
	<form action="lookup.php" method="get">
		Stock:</br>
		<input type="text" name="stockname">
		<input type="Submit" value="Search">
	</form>
</div>

<div id="portholder">
	<div class="tickbox">
	  <span class="ticker"> CASH </span>
	  <span class="amount"> <?php echo("$".$cash_data[0]["amount"]); ?> </span>
	</div>
	<?php foreach($stock_data as $stock){?>
	<div class="tickbox">
	  <span class="ticker"> <?php echo($stock["stock"]);  ?> </span>
	  <span class="amount"> <?php echo($stock["shares"]); ?> </span>
	</div>
	<?php } ?>
</div>

<?php require("../common/footer.php"); ?>
