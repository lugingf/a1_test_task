<?php

namespace App\Tool;

class PositionSorter
{
    /**
     * @param array $positions
     * @param string $key
     * @return array
     */
    public static function sortByKey(array $positions, string $key): array
    {
        if (empty($positions)) {
            return $positions;
        }

        if (!isset($positions[0]->{$key})) {
            return $positions;
        }

        usort($positions, function ($a, $b) use ($key) {
            return ($a->{$key} < $b->{$key}) ? -1 : 1;
        });
        return $positions;
    }
}