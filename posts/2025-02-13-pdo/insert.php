<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "INSERT INTO `text_test` (`text`) VALUES (:text);";


$conn = new PDO("mysql:host=mysql;dbname=db", 'db_user', 'dp_password');

$stmt = $conn->prepare($sql);
$stmt->execute([
    'text' => 'test'
]);
