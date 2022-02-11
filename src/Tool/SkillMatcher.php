<?php

namespace App\Tool;

use App\Model\Position;

class SkillMatcher
{
    /**
     * @param array $skills
     * @param array $positions
     * @return Position
     */
    public static function getBestMatch(array $skills, array $positions): Position
    {
        $lcSkills = array_map('strtolower', $skills);
        $bestMatchId = -1;
        $bestMatchRate = 0;
        /** @var Position $position */
        foreach ($positions as $i => $position) {
            $matchRate = 0;
            foreach ($position->skillSet as $positionSkill) {
                if (in_array(strtolower($positionSkill), $lcSkills)) {
                    $matchRate++;
                }
            }
            if ($matchRate > $bestMatchRate) {
                $bestMatchId = $i;
                $bestMatchRate = $matchRate;
            }
        }
        return $positions[$bestMatchId];
    }
}