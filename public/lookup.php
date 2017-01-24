<?php 
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
?>

<?php
    $stockname = $_GET["stockname"];
    
    //TODO: Move this function somewhere else
    function stock_data($stockname){
        /*
        * Given an input stock id, return an associative
        * array containing its:
        * - stock id
        * - asking price
        * - bidding price
        */
        $fetch_str = "http://finance.yahoo.com/d/quotes.csv?s=".$stockname."&f=ab";
        $data_arr = explode(',', file_get_contents($fetch_str)); 
        $data_assoc = array("stock_name"=>$stockname, "asking_price"=>$data_arr[0], "bidding_price"=>$data_arr[1]) ;
        return $data_assoc;
    };
    $stock_info = stock_data($stockname);
    var_dump($stock_info);
?>

<div id="stockinfo">
        <h1><?php echo($stock_info["stock_name"]); ?></h1>
        <h2><?php echo("Asking Price: $".$stock_info["asking_price"]); ?></h2>
        <h2><?php echo("Bidding Price: $".$stock_info["bidding_price"]); ?></h2>
        <?php if($stock_info["asking_price"] != "N/A"):?>
            <form action="buystock.php" method="post">
                <input type="hidden" name="stockname" value=<?php echo("\"".$stock_info["stock_name"]."\""); ?> />
                <input type="hidden" name="askingprice" value=<?php echo("\"".$stock_info["asking_price"]."\""); ?> />
                <input type="submit" value="Buy" />
            </form>
        <?php endif; ?>
</div>

<?php require("../common/footer.php"); ?>