---
title: 'UUIDs as primary key'
taxonomy:
    tag:
        - JS
date: '2025-02-26'
---

In my next task at work, i have to import data from an api with uuds as primary key and relations between the data entities.    
Shopware also use since version 6 uuids insted of integers as primary keys.    
In this article i want to descripe best practices to handle uuids in mysql databases.

## whats it

UUids are a (most randomly) 16 byte unique identifire.    
A example 32 byte Char representation is: ```8fb12b2f-9183-456f-a50f-0b37720710c6```   

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
In the example you see, that some random bits are replaced with a uuid version information.
For more informations about uuds check the links below this article.

## Why UUIds
   
Unlike continuous numbers, uuids are not enumerable.    
So you can use the uuid in urls without give the user informations about the quantity of data rows in the system or the posibility to manipulate the url to  guess the next data row.

UUids are practicly collision free. Means a generated uuid is globally unique. 
For example, the space of V4 uudis is 2^122 = 5,3169 × 10^36.
In words: "Only after generating 1 billion UUIDs every second for the next 100 years, the probability of creating just one duplicate would be about 50%"


## bretty print

UUids consists are 16 byte (128 bit).

with the funtion ```$hex = bin2hex($binary)``` you can converte the binary data to a hex stringm like '8fb12b2f9183456fa50f0b37720710c6'.    
convert this hex representation to binary use ```$binary = hex2bin($hex)```

Often they used seperated in groups.    
The php code ```$str = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));``` convert the binary data to strings like '8fb12b2f-9183-456f-a50f-0b37720710c6'.    
To revert the UUD to the binary representation ```$binary =  hex2bin(str_replace("-", "", $str))```

## create a table

Best practice so store uuids is a field with the ```BINARY(16)``` data type.

```sql
CREATE TABLE users (
  id BINARY(16) PRIMARY KEY,
  username VARCHAR(255) NOT NULL
);
```

digression: Shopware use the utf8mb4_unicode_ci collaction. its only a random fact. not committed to the uuid topic:)

```sql
CREATE TABLE XXX (
    ...
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## insert row

You can use build in mysql features, like ```INSERT INTO my_table (uuid_column) VALUES (UUID_TO_BIN(UUID()))```.

Its also possible to genrate random bytes and insert them:
```php
$db = new PDO("mysql:dbname=db;host=mysql", "db_user", "dp_password");

$sql = "INSERT INTO users (id, username) VALUES (:id, :username)";
$data = [
    "id" => random_bytes(16),
    "username" => "tester"
];
$db->prepare($sql)->execute($data);
```

in this example i use the php build-in function ```random_bytes(16)``` to generate the random bytes for the key.

## select row

When you query the date from the db and want to display the bytes from the key, then you can use the php function ```bin2hex```.    
This function convert the 16byte binary data into a human readable 32 character string.

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

## uuid V7

There is still the problem that InnoDB stores data in the primary key order. Completly random uuids results in fragmentation and can slow down index traversal and degrade query performance.

In the [shopware sourcecode](https://github.com/shopware/shopware/blob/d9391e13ac343f1164b3543f508541dec1682657/src/Core/Framework/Uuid/Uuid.php#L47) I found the information that shopware use the V7 version of uuids.
V7 UUID using a timestamp, a counter and a cryptographically strong random number to geneate uuids.   
It generates bytes that combine a 48-bit timestamp in milliseconds since the Unix Epoch with 80 random bits.
That solves the problems of scattered database records and make the uuids sortable in a meaningful way (i.e., insert order)

See a full empamle in the [souce code here](https://github.com/falk-m/blog/tree/master/posts/2025-02-26-uuids).

## optimization

[pingcap](https://www.pingcap.com/article/mastering-uuid-storage-in-mysql/) descript in their article diffrent ways to performance improvements.

- clustered indexes ```CREATE TABLE my_table (  uuid_column BINARY(16) PRIMARY KEY CLUSTERED,  ...)```
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
