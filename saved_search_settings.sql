CREATE TABLE ebay.saved_search_settings
(
    id int PRIMARY KEY NOT NULL,
    user_id int NOT NULL,
    name VARCHAR(255) NOT NULL,
    q VARCHAR(255) NOT NULL,
    sort VARCHAR(255) NOT NULL,
    category int NOT NULL,
    freeShipping tinyint NOT NULL,
    MinBid int NOT NULL,
    MaxBid int NOT NULL,
    MinPrice FLOAT NOT NULL,
    MaxPrice FLOAT NOT NULL,
    Auction tinyint NOT NULL,
    FixedPrice tinyint NOT NULL
);