<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\Exception\DistrictEntryAndExitOfVehiclesControlNotExist;
use App\Shared\Domain\ValueObject\Uuid;

final class DistrictEntryAndExitOfVehiclesControlFinder
{
    private DistrictEntryAndExitOfVehiclesControlRepository $repository;

    public function __construct(DistrictEntryAndExitOfVehiclesControlRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id): DistrictEntryAndExitOfVehiclesControl
    {
        $id = new Uuid($id);

        $districtEntryAndExitOfVehiclesControl = $this->repository->search($id);

        if (null === $districtEntryAndExitOfVehiclesControl) {
            throw new DistrictEntryAndExitOfVehiclesControlNotExist($id);
        }

        return $districtEntryAndExitOfVehiclesControl;
    }
}
