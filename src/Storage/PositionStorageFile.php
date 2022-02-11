<?php

namespace App\Storage;

use App\Model\Position;
use App\Tool\FileReader;
use App\Tool\PositionBuilder;

class PositionStorageFile implements PositionStorageInterface
{
    /**
     * @var FileReader
     */
    private $source;

    const FIELD_COUNTRY = "country";
    const FIELD_CITY = "city";
    const FIELD_CURRENCY = "currency";
    const FIELD_SALARY = "salary";
    const FIELD_SENIORITY_LEVEL = "seniorityLevel";

    public function __construct(FileReader $fileReader)
    {
        $this->source = $fileReader;
    }

    /**
     * @return \Generator|Position
     */
    private function positionsGenerator(): \Generator
    {
        foreach ($this->source->getFileLines() as $row) {
            yield PositionBuilder::getFromRaw($row);
        }
    }

    public function getById(int $id): ?Position
    {
        foreach ($this->positionsGenerator() as $position){
            if ($position->id === $id) {
                return $position;
            }
        }
        return null;
    }

    /**
     * Filters are not strict. So it returns position if any of filters match
     * @param array $filters
     * @return Position[]
     */
    public function getByFilter(array $filters): array
    {
        $result = [];
        /** @var Position $position */
        foreach ($this->positionsGenerator() as $position) {
            if (array_key_exists(self::FIELD_COUNTRY, $filters)
                && $position->country === $filters[self::FIELD_COUNTRY]) {
                $result[] = $position;
                continue;
            }

            if (array_key_exists(self::FIELD_CITY, $filters)
                && $position->city === $filters[self::FIELD_CITY]) {
                $result[] = $position;
                continue;
            }

            if (array_key_exists(self::FIELD_SENIORITY_LEVEL, $filters)
                && $position->seniorityLevel === $filters[self::FIELD_SENIORITY_LEVEL]) {
                $result[] = $position;
                continue;
            }

            if (array_key_exists(self::FIELD_SALARY, $filters)
                && $position->currency === $filters[self::FIELD_CURRENCY]
                && $position->salary >= intval($filters[self::FIELD_SALARY])) {
                $result[] = $position;
                continue;
            }
        }
        return $result;
    }

    /**
     * @param array $skills
     * @return Position[]
     */
    public function getBySkills(array $skills): array
    {
        $result = [];
        /** @var Position $position */
        foreach ($this->positionsGenerator() as $position) {
            $positionSkillSet = array_map('strtolower', $position->skillSet);
            foreach ($skills as $skill) {
                if (in_array(strtolower($skill), $positionSkillSet)) {
                    $result[] = $position;
                    break;
                }
            }
        }
        return $result;
    }
}