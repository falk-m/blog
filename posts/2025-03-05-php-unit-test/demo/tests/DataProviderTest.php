<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{
    protected function getTestData()
    {
        return [
            [1, 1],
            [2, 2],
            [3, 3]
        ];
    }

    /**
     * @dataProvider getTestData
     */
    public function test_data_from_provider(int $number1, int $number2)
    {
        $this->assertSame($number1,  $number2, 'is the same');
    }
}
