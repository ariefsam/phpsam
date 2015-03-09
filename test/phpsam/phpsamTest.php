<?php
class PhpsamTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testCanBeNegated()
    {
        // Arrange
        $a = new phpsam();

        // Act
        $b = $a->test();

        // Assert
        $this->assertEquals('tests', $b);
    }

    // ...
}