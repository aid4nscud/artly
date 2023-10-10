CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(256) NOT NULL UNIQUE,
    email VARCHAR(256) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    role ENUM('artist', 'collector', 'admin') NOT NULL,
    date_joined DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE artist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    biography TEXT,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE collector (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    preferences TEXT,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE art (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artist_id INT,
    name VARCHAR(256) NOT NULL,
    dimensions TEXT,
    medium TEXT,
    image_url VARCHAR(256),
    FOREIGN KEY (artist_id) REFERENCES artist(id)
);

CREATE TABLE auction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artist_id INT,
    art_id INT,
    start_price DECIMAL(10, 2) NOT NULL,
    bid_increment DECIMAL(10, 2) NOT NULL,
    end_time DATETIME NOT NULL,
    FOREIGN KEY (artist_id) REFERENCES artist(id),
    FOREIGN KEY (art_id) REFERENCES art(id)
);

CREATE TABLE bid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auction_id INT,
    collector_id INT,
    bid_price DECIMAL(10, 2) NOT NULL,
    bid_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (auction_id) REFERENCES auction(id),
    FOREIGN KEY (collector_id) REFERENCES collector(id)
);

CREATE TABLE transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auction_id INT,
    payment_details TEXT,
    FOREIGN KEY (auction_id) REFERENCES auction(id)
);
