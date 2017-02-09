<?php namespace fetch;
function stock_data($stockname){
    /*
    * Given an input stock id, return an associative
    * array containing its:
    * - stock id
    * - asking price
    * - bidding price
    */
    $stockname = strtoupper($stockname);
    $fetch_str = "http://finance.yahoo.com/d/quotes.csv?s=".$stockname."&f=ab";
    $data_arr = explode(',', file_get_contents($fetch_str));
    $data_assoc = array("stock_name"=>$stockname, "asking_price"=>$data_arr[0], "bidding_price"=>$data_arr[1]) ;
    return $data_assoc;
};
?>
