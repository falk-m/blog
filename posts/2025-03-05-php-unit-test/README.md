---
title: 'basic instruction to php unit tests'
taxonomy:
    tag:
        - PHP
date: '2025-03-05'
---

It follows a short basic instruction to start with unit tests in PHP.

## Install

There are some other ways, but the best way is to install with composer.

```json
{
    "require-dev": {
        "phpunit/phpunit": "^9.5"
    }
}
```

## Execution

Before we start to implement tests, we take a look how to execute the tests.

We want to implement all our tests in the "./tests" directory.    
So we can execute the test in the terminal with the command ```./vendor/bin/phpunit ./tests```.
If the file is not executable try ```php ./vendor/bin/phpunit ./tests```

I use two additional parameters to prevent caching and for more detailed output:    
```./vendor/bin/phpunit --verbose --do-not-cache-result ./tests```

## simple test case

If you don't change the configuration, a test file has to end of 'Test.php' to be auto-detected from the PHP unit test execution script.
In these files tests will be executed when the class extents the 'TestCase' Class.
A test function has to start with 'test'.

```php
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{

    public function test_asserts()
    {
        $this->assertSame("same", "same", 'has to be the same');
    }
}
```

Most test case function include tree parts. Setup - Act - Assert.    
Setup means to configure the test, create mocks and so on.
Then you act the function to rest. At the end compare the result with the expected value.

## Assertion

Each test should have minimum one assertion.    
Use your IDE intelligence to see the options your test class inherits from the parent class.    
Here are some examples:

```php
    $this->assertContains("is", ["is", "in"]);
    $this->assertArrayHasKey("is", ["is" => "", "in" => ""]);
    $this->assertTrue(1 == 1);
```

## Data provider

Instead of write multiple test functions, in some cases it could be useful to reuse the same function with different data.   
Data provider handle this for you. Assign the provider to the function over the "@dataProvider" annotation.

In the example we test a squared function:

```php
class DataProviderTest extends TestCase
{
    protected function getTestData()
    {
        return [
            [1, 1],
            [2, 4],
            [3, 9]
        ];
    }

    /**
     * @dataProvider getTestData
     */
    public function test_data_from_provider(int $number, int $sqr)
    {
        $subject = new MathClass();

        $result = $subject->sqr($number);

        $this->assertSame($sqr, $result, 'is the same');
    }
}
```

## Mocking

We want to test this class:

```php
class DataHub
{
    public function __construct(private Api $api) {}

    public function getData()
    {
        $res = $this->api->fetch("/data");
        return $res;
    }
}
```

The hub uses an API object to fetch data from another system.
In the test, we can use different kinds of technics to prevent API calls to other systems and use dummy data insted.

The test look like this:

```php
public function test_datahub()
{
    //Setup
    $api = $this->getApi();

    //Act
    $subject = new DataHub($api);
    $response = $subject->getData();

    //Assert
    $this->assertSame("response for /data", $response);
}
```

first way is to implement another class (or anonymous class) witch extends the API-class:

 ```php
 /**
 * @return Api;
 */
private function getApi()
{
    return new class() extends Api {

        public function fetch(string $path)
        {
            return "response for $path";
        }
    };
}
```

Another way is to use Stubs.
Stabs produce defined outputs.  

```php
/**
 * @return Api;
 */
private function getApi()
{
    $apiStup = $this->createStub(Api::class);

    $apiStup->method('fetch')->willReturnCallback(function ($path) {
        return "response for $path";
    });

    return $apiStup;
}
```

If you want to test how many times and in what order functions should be called during testing, then use mocks.
Like Stubs, you can use static responses or callback functions or maps.

```php
/**
 * @return Api;
 */
private function getApi()
{
    $api = $this->createMock(Api::class);
    $api->expects($this->once())
        ->method('fetch')
        ->with('/data')
        ->willReturn('response for /data');

    return $api;
}
```

```php
/**
 * @return Api;
 */
private function getApi()
{
    $api = $this->createMock(Api::class);
    $api->expects($this->exactly(2))
        ->method('fetch')
        ->willReturnCallback(function (string $path) {
            return "response for $path";
        });

    return $api;
}
```

## links

- [php unit test intro](https://grobmeier.solutions/de/testen-mit-phpunitphp-f%C3%BCr-anf%C3%A4nger.html)
- [mock-and-stub](https://backendtea.com/post/phpunit-mock-and-stub/)