<?php

namespace AppBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\FizzBuzzService;

class FizzBuzzServiceTest extends TestCase
{

    /** @var FizzBuzzService */
    private $fizzBuzzService;

    private $triggers = [
        ['replacement' => 'fizzbuzz', 'modValue' => 15],
        ['replacement' => 'fizz', 'modValue' => 3],
        ['replacement' => 'buzz', 'modValue' => 5],
    ];

    public function setUp()
    {
        $this->fizzBuzzService = new FizzBuzzService();
    }

    /**
     *
     * @param $rangeStart
     * @param $rangeEnd
     * @param $expected
     *
     * @dataProvider provideGetFizzBuzzDataArrayTestCases
     */
    public function testGetFizzBuzzDataArray($rangeStart, $rangeEnd, $expected)
    {
        $this->assertEquals($expected, $this->fizzBuzzService->getFizzBuzzDataArray($rangeStart, $rangeEnd, $this->triggers));
    }

    /**
     * Tests for an exception when non integers are entered
     */
    public function testGetFizzBuzzDataArrayWithInvalidArgumentTypes()
    {
        $this->expectException('InvalidArgumentException');
        $this->assertEquals('1 2', $this->fizzBuzzService->getFizzBuzzDataArray(1, 'Test string', $this->triggers));
    }

    /**
     * Tests for an exception when the integer range is invalid
     */
    public function testGetFizzBuzzDataArrayWithInvalidRange()
    {
        $this->expectException('InvalidArgumentException');
        $this->assertEquals('1 2', $this->fizzBuzzService->getFizzBuzzDataArray(20, 1, $this->triggers));
    }

    /**
     * Data provider for getFizzBuzzDataArray test cases. Includes negative numbers as there was no restriction to positive integers in the spec.
     *
     * @return array
     */
    public function provideGetFizzBuzzDataArrayTestCases()
    {
        return [
            'negative_numbers' => [ -3, 2, ['fizz', -2, -1, 0, 1, 2]],
            'just_numbers' => [ 1, 2, [1, 2]],
            'one_fizz' => [ 1, 3, [1, 2, 'fizz']],
            'fizz_and_buzz' => [ 1, 5, [1, 2, 'fizz', 4, 'buzz']],
            'test_of_all_replacements' => [ 1, 20, [1, 2, 'fizz', 4, 'buzz', 'fizz', 7, 8, 'fizz', 'buzz', 11, 'fizz', 13, 14, 'fizzbuzz', 16, 17, 'fizz', 19, 'buzz']],
        ];
    }
    
}
