<?php

namespace App\Storage;

use App\Model\Position;

interface PositionStorageInterface
{
    public function getById(int $id): ?Position;
    public function getByFilter(array $filters): array;
    public function getBySkills(array $filters): array;
}