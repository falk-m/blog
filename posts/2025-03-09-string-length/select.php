<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT * FROM `text_test` WHERE id > :min_id";


$conn = new PDO("mysql:host=mysql;dbname=db", 'db_user', 'dp_password');

$stmt = $conn->prepare($sql);
$stmt->execute([
    'min_id' => 0
]);

$data = $stmt->fetchAll();
foreach ($data as $row) {
    echo $row['text'] . "<br />\n";
}

$stmt->execute([
    'min_id' => 0
]);
while ($row = $stmt->fetch()) {
    echo $row['text'] . "<br />\n";
}
