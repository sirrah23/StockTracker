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
  //TODO: Validate these before casting
  $shares_sell = intval($_POST["shares_sell"]);
  $stock_info = fetch\stock_data($stockname);
  var_dump($stock_info);
  echo('<div id="info"> Attempting to sell '.$shares_sell.' shares of '.$stockname." for ".$stock_info['asking_price']." </div>");
?>

<?php require("../common/footer.php"); ?>
