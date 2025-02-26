<?php

use uuid7\UUID7;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/src/UUID7.php');

$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$sql = "INSERT INTO users (id, username, cd) VALUES (:id, :username, :cd)";

for ($i = 0; $i < 10; $i++) {
    $data = [
        "id" => UUID7::randomBytes(),
        "username" => "tester uuid7",
        "cd" => time()
    ];
    $db->prepare($sql)->execute($data);
    sleep(1);
}
