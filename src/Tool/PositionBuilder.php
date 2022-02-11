<?php

namespace App\Tool;

use App\Model\Position;

class PositionBuilder
{
    /**
     * @param array $rawData
     * @return Position
     */
    public static function getFromRaw(array $rawData): Position
    {
        $skillSet = array_map("trim", explode(",", $rawData[7]));
        return new Position(
            intval($rawData[0]), $rawData[1], $rawData[2], $rawData[3], $rawData[4],
            intval($rawData[5]), $rawData[6], $skillSet, $rawData[8], $rawData[9]
        );
    }
}