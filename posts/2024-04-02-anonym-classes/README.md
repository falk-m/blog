---
title: 'anonymous classes in php'
taxonomy:
    tag:
        - PHP
date: '2024-04-02'
---

Since PHP Version 5.3., PHP supports anonymous functions and classes.

Here is an example for an anonymous function:

```php
$add = function(int $a, int $b){
    return $a + $b;
}
```

If you want to use a variable from the external scope use ```use ($c){...``` to reach this variable in the function.

PHP 7.4. supports also arrow functions as shorthand for anonymous functions:

```php
$c = 1;
$add = fn (int $a, int $b) => $a + $b + $c;
```

For single use, it could be practical to use an instance of an anonymous class.

```php

$data = ['zero', 'one', 'two'];

return new class($data)
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($idx)
    {
        return $this->data[$idx];
    }
};

```

You can also use ```implements``` or ```extends``` in our definition.

## Source

- [Anonymous classes](https://www.php.net/manual/en/language.oop5.anonymous.php)
- [Anonymous functions](https://www.php.net/manual/en/functions.anonymous.php)
- [Arrow functions](https://www.php.net/manual/en/functions.arrow.php)