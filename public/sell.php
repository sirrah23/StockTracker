<?php
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
    require("../common/fetch.php");
?>

<?php

    //Initialize variables
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    $stockname = strtoupper($_POST["stock"]);

    //TODO: Move function somewhere else
    function sell_stock($userid, $stockname, $shares, $price){
		//TODO: Move PDO initialization code to separate place
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
		$stmt = $pdo->prepare("CALL sell_stock(?,?,?,?)");
		//TODO: Check this for errors...Try/Catch?
		$stmt->execute(array($userid, $stockname, $shares, $price));
		$stmt->closeCursor();
	}

    //TODO: Validate these before casting
    $shares_sell = intval($_POST["shares_sell"]);
    $stock_info = fetch\stock_data($stockname);
    $asking_price = floatval($stock_info['asking_price']);
    //userid, stockname, shares_sell, asking_price
    sell_stock($userid, $stockname, $shares_sell, $asking_price);
    echo('<div id="info"> You sold '.$shares_sell.' shares of '.$stockname." for ".$stock_info['asking_price']." </div>");
?>

<?php require("../common/footer.php"); ?>
