<?php

namespace App\Backoffice\VehicleMakerName\Application\Delete;

use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;

final class VehicleMakerNameDeleter
{
    private VehicleMakerNameRepository $repository;

    private VehicleMakerNameFinder $finder;

    public function __construct(
        VehicleMakerNameRepository $repository
    ) {
        $this->repository = $repository;
        $this->finder     = new VehicleMakerNameFinder($repository);
    }

    public function __invoke(string $id)
    {
        $vehicleMakerName = $this->finder->__invoke($id);

        $this->repository->delete($vehicleMakerName);
    }
}
