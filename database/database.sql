CREATE DATABASE IF NOT EXISTS shop_project;
USE shop_project;

CREATE TABLE IF NOT EXISTS supportedCountries (
    countryCode VARCHAR(3) NOT NULL PRIMARY KEY,
    countryName VARCHAR(30),
    continent VARCHAR(10)
);

CREATE TABLE IF NOT EXISTS customers (
    customerId VARCHAR(5) NOT NULL PRIMARY KEY,
    birthdate DATE,
    name VARCHAR(15),
    surname VARCHAR(25),
    iban VARCHAR(32),
    email VARCHAR(255),
    phonenumber VARCHAR(24),
    countryOrigin VARCHAR(3)
);

CREATE TABLE IF NOT EXISTS products (
    productId VARCHAR(5) NOT NULL,
    supplierId VARCHAR(5) NOT NULL,
    productName VARCHAR(20),
    sale TINYINT UNSIGNED,
    tags TEXT,
    productDesciption TEXT,
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

-- V L A M / View, Library, Action, Model

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