<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
    public function test_with_custom_implementation()
    {
        //Setup
        $api = $this->getCustomApi();

        //Act
        $subject = new DataHub($api);
        $response = $subject->getData();

        //Assert
        $this->assertSame("custom response for /data", $response);
    }

    public function test_with_stub()
    {
        //Setup
        $api = $this->getApiStub();

        //Act
        $subject = new DataHub($api);
        $response = $subject->getData();

        //Assert
        $this->assertSame("stub response for /data", $response);
    }

    public function test_with_mock()
    {
        //Setup
        $api = $this->getApiMock();

        //Act
        $subject = new DataHub($api);
        $response = $subject->getData();

        //Assert
        $this->assertSame("mock response for /data", $response);
    }

    public function test_with_mock_callback()
    {
        //Setup
        $api = $this->getApiMockWithCallback();

        //Act
        $subject = new DataHub($api);
        $subject->getData();
        $response = $subject->getData();

        //Assert
        $this->assertSame("mock response for /data", $response);
    }

    /**
     * @return Api;
     */
    private function getCustomApi()
    {
        return new class() extends Api {

            public function fetch(string $path)
            {
                return "custom response for $path";
            }
        };
    }

    /**
     * @return Api;
     */
    private function getApiStub()
    {
        $apiStup = $this->createStub(Api::class);
        $apiStup->method('getTime')
            ->willReturn(111);

        $apiStup->method('fetch')->willReturnCallback(function ($path) {
            return "stub response for $path";
        });

        return $apiStup;
    }

    /**
     * @return Api;
     */
    private function getApiMock()
    {
        $api = $this->createMock(Api::class);
        $api->expects($this->once())
            ->method('fetch')
            ->with('/data')
            ->willReturn('mock response for /data');

        return $api;
    }

    /**
     * @return Api;
     */
    private function getApiMockWithCallback()
    {
        $api = $this->createMock(Api::class);
        $api->expects($this->exactly(2))
            ->method('fetch')
            ->willReturnCallback(function (string $path) {
                return "mock response for $path";
            });

        return $api;
    }
}

class DataHub
{

    public function __construct(private Api $api) {}

    public function getData()
    {
        $res = $this->api->fetch("/data");
        return $res;
    }
}

class Api
{

    public function getTime()
    {
        return time();
    }

    public function fetch(string $path)
    {
        return "{ some json sting}";
    }
}
