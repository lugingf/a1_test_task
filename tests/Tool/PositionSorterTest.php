<?php

namespace App\Tests\Model;

use App\Model\Position;
use App\Tool\PositionSorter;
use PHPUnit\Framework\TestCase;

class PositionSorterTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param array $positions
     * @param string $key
     * @param array $expectedArray
     * @param string $testName
     */
    public function testSortByKey(array $positions, string $key, array $expectedArray, string $testName): void
    {
        $sorted = PositionSorter::sortByKey($positions, $key);
        $this->assertEquals($expectedArray, $sorted, $testName);
    }

    public function dataProvider(): array
    {
        return [
            [
                [
                    new Position(1, "", "Middle", "", "", 600000, "EUR", [], "", ""),
                    new Position(2, "", "Middle", "", "", 300000, "EUR", [], "", ""),
                    new Position(3, "", "Middle", "", "", 550000, "EUR", [], "", ""),
                ],
                'salary',
                [
                    new Position(2, "", "Middle", "", "", 300000, "EUR", [], "", ""),
                    new Position(3, "", "Middle", "", "", 550000, "EUR", [], "", ""),
                    new Position(1, "", "Middle", "", "", 600000, "EUR", [], "", ""),
                ],
                'By salary',
            ],
            [
                [
                    new Position(1, "", "Senior", "", "", 100, "EUR", [], "", ""),
                    new Position(2, "", "Junior", "", "", 100, "EUR", [], "", ""),
                    new Position(3, "", "Middle", "", "", 100, "EUR", [], "", ""),
                ],
                'seniorityLevel',
                [
                    new Position(2, "", "Junior", "", "", 100, "EUR", [], "", ""),
                    new Position(3, "", "Middle", "", "", 100, "EUR", [], "", ""),
                    new Position(1, "", "Senior", "", "", 100, "EUR", [], "", ""),
                ],
                'By seniorityLevel'
            ],
            [
                [
                    new Position(1, "", "Senior", "", "", 100, "EUR", [], "", ""),
                    new Position(2, "", "Junior", "", "", 100, "EUR", [], "", ""),
                    new Position(3, "", "Middle", "", "", 100, "EUR", [], "", ""),
                ],
                'someWrongKey',
                [
                    new Position(1, "", "Senior", "", "", 100, "EUR", [], "", ""),
                    new Position(2, "", "Junior", "", "", 100, "EUR", [], "", ""),
                    new Position(3, "", "Middle", "", "", 100, "EUR", [], "", ""),
                ],
                'By unexpected Key'
            ],
        ];
    }
}