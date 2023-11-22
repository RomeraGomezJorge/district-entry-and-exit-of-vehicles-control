<?php

declare(strict_types=1);

namespace App\Backoffice\VehicleMakerName\Infrastructure\Specification;

use App\Backoffice\VehicleMakerName\Domain\UniqueVehicleMakerNameDescriptionSpecification;
use App\Backoffice\VehicleMakerName\Infrastructure\Persistence\MySqlVehicleMakerNameRepository;

final class MySqlUniqueVehicleMakerNameDescriptionSpecification implements UniqueVehicleMakerNameDescriptionSpecification
{
    private MySqlVehicleMakerNameRepository $repository;

    public function __construct(MySqlVehicleMakerNameRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isSatisfiedBy(string $description): bool
    {
        return !$this->repository->isDescriptionExits(array('description' => $description));
    }
}
