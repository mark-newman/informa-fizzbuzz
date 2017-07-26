<?php

namespace AppBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\FizzBuzzService;

class FizzBuzzServiceTest extends TestCase
{

    /** @var FizzBuzzService */
    private $fizzBuzzService;

    private $defaultTriggers;

    public function setUp()
    {
        $this->fizzBuzzService = new FizzBuzzService();

        $this->defaultTriggers = [
            [
                'replacement' => 'fizzbuzz',
                'function' => function($i){
                    return ($i % 15 == 0 && $i != 0);
                }
            ],
            [
                'replacement' => 'fizz',
                'function' => function($i){
                    return ($i % 3 == 0 && $i != 0);
                }
            ],
            [
                'replacement' => 'buzz',
                'function' => function($i){
                    return ($i % 5 == 0 && $i != 0);
                }
            ],
        ];
    }

    /**
     *
     * @param $rangeStart
     * @param $rangeEnd
     * @param $expected
     *
     * @dataProvider provideGetFizzBuzzStringTestCases
     */
    public function testGetFizzBuzzString($rangeStart, $rangeEnd, $expected)
    {
        $this->assertEquals($expected, $this->fizzBuzzService->getFizzBuzzString($rangeStart, $rangeEnd, $this->defaultTriggers));
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
        $this->assertEquals($expected, $this->fizzBuzzService->getFizzBuzzDataArray($rangeStart, $rangeEnd, $this->defaultTriggers));
    }

    /**
     * Tests for an exception when non integers are entered
     */
    public function testGetFizzBuzzDataArrayWithInvalidArgumentTypes()
    {
        $this->expectException('InvalidArgumentException');
        $this->assertEquals('1 2', $this->fizzBuzzService->getFizzBuzzDataArray(1, 'Test string', $this->defaultTriggers));
    }

    /**
     * Tests for an exception when the integer range is invalid
     */
    public function testGetFizzBuzzDataArrayWithInvalidRange()
    {
        $this->expectException('InvalidArgumentException');
        $this->assertEquals('1 2', $this->fizzBuzzService->getFizzBuzzDataArray(20, 1, $this->defaultTriggers));
    }

    /**
     * Data provider for getFizzBuzzString test cases. Includes negative numbers as there was no restriction to positive integers in the spec.
     *
     * @return array
     */
    public function provideGetFizzBuzzStringTestCases()
    {
        return [
            'negative_numbers' => [ -3, 2, 'fizz -2 -1 0 1 2'],
            [ 1, 2, '1 2'],
            [ 1, 3, '1 2 fizz'],
            [ 1, 5, '1 2 fizz 4 buzz'],
            [ 1, 20, '1 2 fizz 4 buzz fizz 7 8 fizz buzz 11 fizz 13 14 fizzbuzz 16 17 fizz 19 buzz'],
        ];
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
