<?php

use uuid7\UUID7;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/src/UUID7.php');

$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$sql = "SELECT id, username, cd FROM users";

$stmt = $db->prepare($sql);
$stmt->execute();

echo "<table border='1'>";
while ($row = $stmt->fetch()) {
    //$id = bin2hex($row['id']);
    $id = UUID7::brettyPrint($row['id']);
    echo sprintf(
        "<tr><td>%s</td><td>%s</td><td>%s</td></tr>",
        $id,
        $row['username'],
        date("Y.m.d - H:i:s", $row['cd'])
    );
}
echo "</table>";
