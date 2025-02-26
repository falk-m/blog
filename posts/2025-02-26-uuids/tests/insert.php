<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$id = bin2hex(random_bytes(16));

$sql = "INSERT INTO users (id, username, cd) VALUES (:id, :username, :cd)";
$data = [
    "id" => hex2bin($id),
    "username" => "tester",
    "cd" => time()
];
$db->prepare($sql)->execute($data);
