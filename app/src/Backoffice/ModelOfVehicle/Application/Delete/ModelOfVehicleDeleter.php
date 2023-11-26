<?php

namespace App\Backoffice\ModelOfVehicle\Application\Delete;

use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;

final class ModelOfVehicleDeleter
{
    private ModelOfVehicleRepository $repository;

    private ModelOfVehicleFinder $finder;

    public function __construct(
        ModelOfVehicleRepository $repository
    ) {
        $this->repository = $repository;
        $this->finder     = new ModelOfVehicleFinder($repository);
    }

    public function __invoke(string $id)
    {
        $modelOfVehicle = $this->finder->__invoke($id);

        $this->repository->delete($modelOfVehicle);
    }
}
