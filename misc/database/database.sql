CREATE DATABASE IF NOT EXISTS shop_project;
USE shop_project;

CREATE TABLE IF NOT EXISTS supportedCountries (
    countryCode VARCHAR(3) NOT NULL PRIMARY KEY,
    countryName VARCHAR(30),
    continent VARCHAR(10)
); -- sad

CREATE TABLE IF NOT EXISTS images {
    productId VARCHAR(5) NOT NULL PRIMARY KEY,
    image LONGBLOB,
    isThumbnail BOOLEAN
};

CREATE TABLE IF NOT EXISTS shoppingCart (
    customerId VARCHAR(5) NOT NULL,
    productId VARCHAR(5) NOT NULL,
    amount TINYINT UNSIGNED,
    PRIMARY KEY (customerId, productId)
);

CREATE TABLE IF NOT EXISTS customers (
    customerId VARCHAR(5) NOT NULL PRIMARY KEY,
    birthdate DATE,
    name VARCHAR(15),
    surname VARCHAR(25),
    iban VARCHAR(32),
    email VARCHAR(255),
    phonenumber VARCHAR(24),
    countryOrigin VARCHAR(3) DEFAULT "US"
);

CREATE TABLE IF NOT EXISTS products (
    productId VARCHAR(5) NOT NULL,
    supplierId VARCHAR(5) NOT NULL,
    productName VARCHAR(20),
    price FLOAT(10, 2) DEFAULT 0,
    sale TINYINT UNSIGNED,
    tags TEXT,
    productDescription TEXT,
    availableCountry VARCHAR(3),
    PRIMARY KEY (productId, supplierId)
);

CREATE TABLE IF NOT EXISTS suppliers (
    supplierId VARCHAR(5) NOT NULL PRIMARY KEY,
    email VARCHAR(255),
    name VARCHAR(50),
    date DATE
);

CREATE TABLE IF NOT EXISTS orders (
    productId VARCHAR(5) NOT NULL,
    customerId VARCHAR(5) NOT NULL,
    amount TINYINT UNSIGNED,
    creationDate DATETIME,
    shipping BOOLEAN,
    arrivedAt DATETIME,
    refunded BOOLEAN,
    PRIMARY KEY (productId, customerId)
);

CREATE TABLE IF NOT EXISTS productComments (
    productId VARCHAR(5) NOT NULL,
    customerId VARCHAR(5) NOT NULL,
    creationDate DATETIME NOT NULL,
    text LONGTEXT,
    stars TINYINT UNSIGNED,
    PRIMARY KEY (productId, customerId, creationDate)
);

CREATE TABLE IF NOT EXISTS productReports (
    reportId VARCHAR(5) NOT NULL,
    productId VARCHAR(5) NOT NULL,
    reporteeId VARCHAR(5),
    isSeller BOOLEAN,
    text LONGTEXT,
    created DATE,
    handled DATE,
    PRIMARY KEY (reportId, productId)
);