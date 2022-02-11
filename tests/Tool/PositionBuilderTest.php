<?php

namespace App\Tests\Factory;

use App\Model\Position;
use App\Tool\PositionBuilder;
use PHPUnit\Framework\TestCase;

class PositionBuilderTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param array $row
     */
    public function createPosition(array $row, Position $expected): void
    {
        $position = PositionBuilder::getFromRaw($row);

        $this->assertInstanceOf(Position::class, $position);
        $this->assertEquals($expected, $position);
    }

    public function dataProvider(): array
    {
        return [
            [
                [1, 'Job title', 'Middle', 'DE', 'Berlin', 600000, 'SUV', 'PHP,Go', '10-20', 'Ecom'],
                new Position(1, "Job title", "Middle", "DE", "Berlin", 600000, "SUV", ["PHP", "Go"], "10-20", "Ecom")
            ]
        ];
    }
}