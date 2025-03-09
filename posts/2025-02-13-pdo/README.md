---
title: 'PHP PDO Basics'
taxonomy:
    tag:
        - PHP
date: '2025-02-13'
---

This little post is not about SQL or SQL syntax, only a little example about the usage of the PHP PDO adapter for database query.

## Create connection

```php
$conn = new PDO("mysql:host=mysql;dbname=db", 'db_user', 'dp_password');
```

## Create a table

```php
$sql = "CREATE TABLE IF NOT EXISTS `text_test` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `text` VARCHAR(100) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$conn->query($sql);
```

## Insert row

```php
$sql = "INSERT INTO `text_test` (`text`) VALUES (:text);";

$stmt = $conn->prepare($sql);
$stmt->execute([
    'text' => 'test'
]);
```

# Select rows (statement with parameter)

execute statement

```php
$sql = "SELECT * FROM `text_test` WHERE id > :min_id";

$stmt = $conn->prepare($sql);
$stmt->execute([
    'min_id' => 0
]);
```

fetch all rows

```php
$data = $stmt->fetchAll();
foreach ($data as $row) {
    echo $row['text'] . "<br />\n";
}
```

fetch row by row

```php
while ($row = $stmt->fetch()) {
    echo $row['text'] . "<br />\n";
}
```