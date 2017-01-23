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
?>

<div id="stockinfo">
    <?php
        echo("The requested stock is ".$stock_info["stock_name"].".</br>");
        echo("The asking price is $".$stock_info["asking_price"].".</br>");
        echo("The bidding price is $".$stock_info["bidding_price"].".</br>");
    ?>
</div>

<?php require("../common/footer.php"); ?>