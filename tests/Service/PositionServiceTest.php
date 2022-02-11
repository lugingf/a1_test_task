<?php

namespace Tests\App\Service;

use App\Model\Position;
use App\Service\PositionService;
use App\Storage\PositionStorageInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class PositionServiceTest
 */
class PositionServiceTest extends TestCase
{
    public function testGetPositionById()
    {
        $storage = $this->getMockBuilder(PositionStorageInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(["getById", "getByFilter", "getBySkills"])
            ->getMock();
        $storage->method("getById")
            ->willReturn(
                new Position(1, "Job title", "Middle", "DE", "Berlin", 600000, "SUV", ["PHP", "Go"], "10-20", "Ecom")
            );
        $service = new PositionService($storage);

        self::assertEquals(
            new Position(1, "Job title", "Middle", "DE", "Berlin", 600000, "SUV", ["PHP", "Go"], "10-20", "Ecom"),
            $service->getPositionById(1)
        );
    }
}
