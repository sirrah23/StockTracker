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