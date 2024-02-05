---
title: 'Mongo Light'
taxonomy:
    tag:
        - PHP
date: '2023-12-10'
---

There is a great CRM System [EspoCrm](https://www.espocrm.com/de/).
In Espo, you can administrate the object types, their properties and their relations in the user interface.
This schema is then automatically created in a MySQL database.
This is a create feature. But for little projects, I prefer a database-less solution or at least a SQLite approach.

[Cockpit](https://getcockpit.com/) provides this. You can use the MongoDB interface or SQLite.
So, I tested it and took a look at the created SQLite file.
Each object type has its own table. the table only contains an id column and a data column🤔
In the data column is a JSON object serialized.

Cockpit uses the [sqliteCreateFunction](https://www.php.net/manual/en/pdo.sqlitecreatefunction.php) feature to registrate a php function in the pdo-adapter. This function is called in the database queries, deserializes the data column value and executes some other operations on the value. 

This technique is called 'mongo-light' and should be performant in cases of up to 100k data rows.

Here is an example registration of a function:
```php
 $pdo->sqliteCreateFunction('document_criteria',   
    function ($value) {
        return $value == 'test';
    }
    , 1);
```

Then you can use this function in your queries:

```sql
SELECT * FROM documents where document_criteria(title)
```

Here [a link to the implementation](https://github.com/agentejo/cockpit/blob/next/lib/MongoLite/Database.php) used in the Cockpit-project.