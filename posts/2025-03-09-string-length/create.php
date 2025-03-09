<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "CREATE TABLE IF NOT EXISTS `text_test` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `text` VARCHAR(100) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";


$conn = new PDO("mysql:host=mysql;dbname=db", 'db_user', 'dp_password');

$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS `text_test2` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;";

$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS `text_test4` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;";

$conn->query($sql);
