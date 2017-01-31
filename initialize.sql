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
    IN price DECIMAL(13,2),
    OUT message VARCHAR(30)
)
BEGIN
	-- TODO: What does this return upon failure?
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
	SET shares_new = (SELECT Stocks.shares from Stocks WHERE Stocks.user_id=user_id AND Stocks.stock=stock) + shares;
	
	UPDATE Stocks SET Stocks.shares=shares_new WHERE Stocks.user_id=user_id AND Stocks.stock=stock; 
	UPDATE Cash SET Cash.amount=cash_new WHERE Cash.user_id=user_id;
	
	SET message = "SUCCESS";
    COMMIT;
END//
DELIMITER ;