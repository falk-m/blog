<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$sql = "CREATE table IF NOT EXISTS users (
     id BINARY(16) PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    cd int);";
$db->exec($sql);
