<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{

    public function test_asserts()
    {
        $this->assertSame("same", "same", 'is the same');

        $this->assertContains("is", ["is", "in"]);
        $this->assertArrayHasKey("is", ["is" => "", "in" => ""]);
        $this->assertTrue(1 == 1);
    }
}
