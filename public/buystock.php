<?php 
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
?>

<?php
    $username = $_SESSION["username"];
    $stockname = $_POST["stockname"];
    $price = $_POST["askingprice"];
    $shares = $_POST["shares"];
?>

<div id="info">
    <?php if (!is_numeric($price)):?>
        Price is not a valid number. Cannot buy.
    <?php elseif (!is_numeric($shares)):?>
        Shares are not a valid number. Cannot buy.
    <?php else: ?>
        <!--Get the user id for user -->
        <!--Store buy in database-->
    <?php endif; ?>
</div>

<?php require("../common/footer.php"); ?>