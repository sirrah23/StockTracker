<?php 
	require("../common/header.php");
	session_start();
	//TODO: Make sure session has a username
?>

<?php
    //Get variables we will need
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    $stockname = $_POST["stockname"];
    $price = $_POST["askingprice"];
    $shares = $_POST["shares"];

    //TODO: Move function somewhere else
    function update_stock($userid, $stockname, $shares){
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
        $stmt = $pdo->prepare("INSERT INTO Stocks (user_id, stock, shares) VALUES (?,?,?)");
        //TODO: Check this for errors...Try/Catch?
        $stmt->execute(array($userid, $stockname, $shares));
    }
?>

<div id="info">
    <?php if (!is_numeric($price)):?>
        Price is not a valid value. Cannot buy.
    <?php elseif (!is_numeric($shares)):?>
        Shares are not a valid number. Cannot buy.
    <?php else: ?>
        <?php 
            //Valid user input
            //TODO: Update user's cash value as well - Consider transaction + stored proc
            update_stock($userid, $stockname, $shares);
            echo($stockname." has been purchased!");
        ?>
    <?php endif; ?>
</div>

<?php require("../common/footer.php"); ?>