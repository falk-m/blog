<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "INSERT INTO `text_test4` (`text`) VALUES (:text);";


$conn = new PDO("mysql:host=mysql;dbname=db", 'db_user', 'dp_password');

$stmt = $conn->prepare($sql);

/*
$stmt->execute([
    'text' => 'test'
]);

$stmt->execute([
    'text' => '福州建发汽车销售服务有限公司'
]);

echo strlen($text);
$stmt->execute([
    'text' => $text
]);*/

/** With error */

$text = urldecode('%E5');

echo 'length:' . strlen($text);

echo 'letter: ' . $text;

var_dump(mb_ord($text, 'ISO-8859-1'));

$stmt->execute([
    'text' => $text
]);
