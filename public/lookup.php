<?php
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
	require("../common/fetch.php");
?>

<?php
		$stockname = strtoupper($_GET["stockname"]);
    $stock_info = fetch\stock_data($stockname);
?>

<div id="info">
        <h1><?php echo($stock_info["stock_name"]); ?></h1>
        <h2><?php echo("Asking Price: $".$stock_info["asking_price"]); ?></h2>
        <h2><?php echo("Bidding Price: $".$stock_info["bidding_price"]); ?></h2>
        <?php if($stock_info["asking_price"] != "N/A"):?>
            <form action="buystock.php" method="post">
                <input type="hidden" name="stockname" value=<?php echo("\"".$stock_info["stock_name"]."\""); ?> />
                <input type="hidden" name="biddingprice" value=<?php echo("\"".$stock_info["bidding_price"]."\""); ?> />
                Shares:
                <input type="number" name="shares" min="1"/>
                <input type="submit" value="Buy" />
            </form>
        <?php endif; ?>
</div>

<?php require("../common/footer.php"); ?>
