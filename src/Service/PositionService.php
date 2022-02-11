<?php

namespace App\Service;

use App\Model\Position;
use App\Storage\PositionStorageInterface;
use App\Tool\PositionSorter;
use App\Tool\SkillMatcher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PositionService
{
    private $positionStorage;

    private const SORT = "sort";

    public function __construct(PositionStorageInterface $positionStorage)
    {
        $this->positionStorage = $positionStorage;
    }

    /**
     * @param int $id
     * @return Position|null
     */
    public function getPositionById(int $id): ?Position
    {
        $position = $this->positionStorage->getById($id);
        if (!is_null($position)) {
            return $position;
        }

        throw new NotFoundHttpException("Position with ID {$id} not found");
    }

    /**
     * @param array $filters
     * @return Position[]
     */
    public function getPositionsByFilters(array $filters): array
    {
        $positions = $this->positionStorage->getByFilter($filters);
        if (array_key_exists(self::SORT, $filters)) {
            $positions = PositionSorter::sortByKey($positions, $filters[self::SORT]);
        }
        return $positions;
    }

    /**
     * @param array $filters
     * @return Position
     */
    public function getPositionByMatch(array $filters): ?Position
    {
        if (count($filters) == 1 && isset($filters["skills"])) {
            $positions = $this->positionStorage->getBySkills($filters["skills"]);
        } else {
            $positions = $this->positionStorage->getByFilter($filters);
        }
        if (count($positions) == 0) {
            return null;
        }

        return SkillMatcher::getBestMatch($filters["skills"], $positions);
    }
}
