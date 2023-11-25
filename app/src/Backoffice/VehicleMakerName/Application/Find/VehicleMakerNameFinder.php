<?php

namespace App\Backoffice\VehicleMakerName\Application\Find;

use App\Backoffice\VehicleMakerName\Domain\Exception\VehicleMakerNameNotExist;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Domain\ValueObject\Uuid;

final class VehicleMakerNameFinder
{
    private VehicleMakerNameRepository $repository;

    public function __construct(VehicleMakerNameRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id): VehicleMakerName
    {
        $id = new Uuid($id);

        $vehicleMakerName = $this->repository->search($id);

        if (!$vehicleMakerName) {
            throw new VehicleMakerNameNotExist($id);
        }

        return $vehicleMakerName;
    }
}
