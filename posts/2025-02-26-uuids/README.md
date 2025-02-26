---
title: 'UUIDs as primary key'
taxonomy:
    tag:
        - JS
date: '2025-02-26'
---

In my next task at work, I have to import data from an API which use UUIDs as primary key and for relations between the data entities.    
Shopware also use UUIDs since version 6 instead of integers as primary keys.    
In this article I want to describe best practices, to handle UUIDs in MySQL databases.

## What's it

UUIDs are a (most randomly) 16 byte unique identifier.    
These 16 bytes mostly are represented as a 32 byte hex character string like this: ```8fb12b2f-9183-456f-a50f-0b37720710c6```   

The simplest way to generate one:

```php
function uuidv4()
{
  $data = random_bytes(16);

  $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    
  return $data;
}
```

In the example you see, that some random bits are replaced with a UUID version information.
For more information about UUIDs check the links below this article.

## Why UUIDs
   
Unlike continuous numbers, UUIDs are not enumerable.    
So you can use the UUID in URLs without give the user information about the quantity of data rows in the system or the possibility to manipulate the URL to guess the next data row.

UUIDs are practically collision free. Means a generated UUID is globally unique. 
For example, the space of V4 UUIDs is 2^122 = 5,3169 × 10^36.
In words: "Only after generating 1 billion UUIDs every second for the next 100 years, the probability of creating just one duplicate would be about 50%"


## Pretty print

UUIDs consists are 16 byte (128 bit).

The function ```$hex = bin2hex($binary)``` convert the binary data to a hex string like '8fb12b2f9183456fa50f0b37720710c6'.    
Convert these hex representation back to binary use ```$binary = hex2bin($hex)```.

Often these hex characters are separated in groups.    
The PHP code ```$str = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));``` convert the binary data to strings like '8fb12b2f-9183-456f-a50f-0b37720710c6'.    
To revert the UUID to the binary representation use ```$binary =  hex2bin(str_replace("-", "", $str))```.

## Create a table

Best practice so store UUIDs is a field with the ```BINARY(16)``` data type.

```sql
CREATE TABLE users (
  id BINARY(16) PRIMARY KEY,
  username VARCHAR(255) NOT NULL
);
```

Digression: Shopware uses the "utf8mb4_unicode_ci" collection. It's only a random fact, not committed to the UUID topic:)

```sql
CREATE TABLE XXX (
    ...
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## insert row

You can use built-in MySQL features, like ```INSERT INTO my_table (uuid_column) VALUES (UUID_TO_BIN(UUID()))```.

It's also possible to generate random bytes and insert them:
```php
$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$sql = "INSERT INTO users (id, username) VALUES (:id, :username)";
$data = [
    "id" => random_bytes(16),
    "username" => "tester"
];
$db->prepare($sql)->execute($data);
```

In this example I use the PHP built-in function ```random_bytes(16)``` to generate the random bytes for the key.

## Select rows

When you query the date from the db and want to display the bytes from the key, then you can use the PHP function ```bin2hex```.    
This function convert the 16byte binary data into a human-readable 32 character string.

```php
$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$sql = "SELECT id, username FROM users";

$stmt = $db->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch()) {
    $id = bin2hex($row['id'])
    echo $id . ' - ' . $row['username'] . "<br />\n";
}
```

## UUID V7

There is still the problem that InnoDB stores data in the primary key order. Completely random UUIDs results in fragmentation and can slow down index traversal and degrade query performance.

In the [Shopware source code](https://github.com/shopware/shopware/blob/d9391e13ac343f1164b3543f508541dec1682657/src/Core/Framework/Uuid/Uuid.php#L47) I found the information that Shopware use the V7 version of UUIDs.
V7 UUID using a timestamp, a counter and a cryptographically strong random number to generate UUIDs.   
It generates bytes that combine a 48-bit timestamp in milliseconds since the Unix Epoch with 80 random bits.
That solves the problems of scattered database records and make the UUIDs sortable in a meaningful way (i.e., insert order)

See a full example in the [source code here](https://github.com/falk-m/blog/tree/master/posts/2025-02-26-uuids).

## Optimization

[Pingcap](https://www.pingcap.com/article/mastering-uuid-storage-in-mysql/) describe in their article different ways to performance improvements.

- Clustered indexes ```CREATE TABLE my_table (  uuid_column BINARY(16) PRIMARY KEY CLUSTERED,  ...)```
- Prefix Indexing ```CREATE INDEX idx_prefix ON my_table (uuid_column(8))```
- Partitioning ```CREATE TABLE my_table (  uuid_column BINARY(16),  ...) PARTITION BY HASH(uuid_column)```

## Links

- [uuid-generator](https://it-tools.tech/uuid-generator)
- [Understanding UUIDs](https://www.pingcap.com/article/mastering-uuid-storage-in-mysql/)
- [ramsey/uuid](https://github.com/ramsey/uuid) uuid generator
- [ramsey.dev](https://uuid.ramsey.dev/en/stable/database.html)
- [generate-v4-uuid](https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid)
- [Random_UUID_probability_of_duplicates](https://en.wikipedia.org/wiki/Universally_unique_identifier#Random_UUID_probability_of_duplicates)
- [Universally_Unique_Identifier](https://de.wikipedia.org/wiki/Universally_Unique_Identifier)
- [UUID V7 example](https://github.com/falk-m/blog/tree/master/posts/2025-02-26-uuids)
