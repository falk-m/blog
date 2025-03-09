---
title: 'MySQL, string length and a crazy behavior'
taxonomy:
    tag:
        - PHP
        - MYSQL
date: '2025-03-09'
---

This week I have a very crazy behavior when insert rows in a database.

Given is the following table:

```sql
CREATE TABLE IF NOT EXISTS `text_test` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `text` VARCHAR(100) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

There is a column of type VARCHAR with a max length of 100.

That's the insert statement:

```sql
INSERT INTO `text_test` (`text`) VALUES (:text);
```

When I insert the word 'test', everything works fine.
All test data until a length of 100 characters can be inserted.

Now there was an exception.

```String data, right truncated: 1406 Data too long for column 'text'```

The input is one character, here encoded represented with '%E5' because the character seems to be not printable:

```php
$text = urldecode('%E5');
```

```strlen($text)``` is **1**!

So what the F***!

I also create the table with char set utf16 and utf16_unicode_ci or utf16_bin collection.
Same error.

```var_dump(mb_ord($text, 'ISO-8859-1'))``` display number 229.    
That should be 'Latin Small Letter A With Ring Above', e.g. &aring;    
But this is a letter used in Danish, Norwegian, Swedish. I can insert this character in the database.
The URL encoded representation of this character is '%C3%A5', that's not the char I'm looking for.

So what is this character?
Then I ask ChatGPT, the answer is: 

> The URL-encoded sequence %E5 is part of a multibyte character, most likely in UTF-8 encoding. On its own, %E5 is incomplete and does not represent a full character.
>However, if it is part of a larger sequence (e.g., %E5%AD%97), it could be a Chinese, Japanese, or Korean (CJK) character. %E5 is often the first byte of many Chinese characters in UTF-8.'

That's make sense. The text is from a chinese dataset.
In the future I will check some other public web forms how use query parameter:-)
