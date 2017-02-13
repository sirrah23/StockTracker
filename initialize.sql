CREATE DATABASE StockTracker;

USE StockTracker;

CREATE TABLE Users (
	id MEDIUMINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE Cash (
	id MEDIUMINT NOT NULL AUTO_INCREMENT,
	user_id MEDIUMINT NOT NULL,
    amount DECIMAL(13,2),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES Users (id) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE Stocks(
	id MEDIUMINT NOT NULL AUTO_INCREMENT,
    user_id MEDIUMINT NOT NULL,
    stock VARCHAR(15),
    shares INT,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES Users (id)
) ENGINE=INNODB;

DELIMITER //
CREATE PROCEDURE `buy_stock` (
	IN user_id MEDIUMINT,
    IN stock VARCHAR(15),
    IN shares INT,
    IN price DECIMAL(13,2)
)
BEGIN
	DECLARE cash_new DECIMAL(13,2);
	DECLARE cash_lost DECIMAL(13,2);
	DECLARE shares_new INT;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    START TRANSACTION;
    SET cash_lost = price*shares;
	SET cash_new = (SELECT amount FROM Cash WHERE Cash.user_id=user_id) - cash_lost;
	SET shares_new = (SELECT Stocks.shares from Stocks WHERE Stocks.user_id=user_id AND Stocks.stock=stock);
    
    IF (ISNULL(shares_new)) THEN
		-- If user doesn't own stock then do an insert
		SET shares_new=shares;
        INSERT INTO Stocks (Stocks.user_id, Stocks.stock, Stocks.shares) VALUES (user_id, stock, shares);
	ELSE
		-- If user does own stock then update the shares
		SET shares_new=shares_new + shares;
        UPDATE Stocks SET Stocks.shares=shares_new WHERE Stocks.user_id=user_id AND Stocks.stock=stock;
    END IF;
	
    UPDATE Cash SET Cash.amount=cash_new WHERE Cash.user_id=user_id;
	
    COMMIT;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `sell_stock` (
	IN user_id MEDIUMINT,
    IN stock VARCHAR(15),
    IN shares INT,
    IN price DECIMAL(13,2)
)
proc_label:BEGIN
	DECLARE cash_gain DECIMAL(13,2);
	DECLARE cash_new DECIMAL(13,2);
	DECLARE shares_new INT;
    DECLARE stockpile INT;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    START TRANSACTION;
    SET stockpile = (SELECT Stocks.shares from Stocks WHERE Stocks.user_id=user_id AND Stocks.stock=stock);
    -- TODO: What if somehow the user doesn't own the stock at all?
    IF (stockpile < shares) THEN
        LEAVE proc_label;
    END IF;
    SET cash_gain = shares*price;
	SET cash_new = (SELECT amount FROM Cash WHERE Cash.user_id=user_id) + cash_gain;
	SET shares_new = stockpile - shares;
	UPDATE Cash SET Cash.amount=cash_new WHERE Cash.user_id=user_id;
	UPDATE Stocks SET Stocks.shares=shares_new WHERE Stocks.user_id=user_id AND Stocks.stock=stock;
    COMMIT;
END//
DELIMITER ;