CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(256) NOT NULL UNIQUE,
    email VARCHAR(256) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    role ENUM('artist', 'collector', 'admin') NOT NULL,
    date_joined DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE art (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT, 
    name VARCHAR(256) NOT NULL,
    dimensions TEXT,
    medium TEXT,
    image_url VARCHAR(256),
    auction_id INT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE auction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    art_id INT,
    start_price DECIMAL(10, 2) NOT NULL,
    bid_increment DECIMAL(10, 2) NOT NULL,
    end_time DATETIME NOT NULL,
    status ENUM('active', 'ended', 'sold') DEFAULT 'active',
    FOREIGN KEY (art_id) REFERENCES art(id) ON DELETE CASCADE
);

ALTER TABLE art
    ADD FOREIGN KEY (auction_id) REFERENCES auction(id) ON DELETE SET NULL;

CREATE TABLE bid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auction_id INT,
    user_id INT,
    bid_price DECIMAL(10, 2) NOT NULL,
    bid_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (auction_id) REFERENCES auction(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auction_id INT,
    buyer_id INT,
    amount DECIMAL(10, 2) NOT NULL,
    payment_details TEXT,
    transaction_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    FOREIGN KEY (auction_id) REFERENCES auction(id),
    FOREIGN KEY (buyer_id) REFERENCES user(id)
);