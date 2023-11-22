<?php

namespace App\Backoffice\VehicleBodyType\Application\Find;

use App\Backoffice\VehicleBodyType\Domain\District;
use App\Backoffice\VehicleBodyType\Domain\Exception\VehicleBodyTypeNotExist;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
use App\Shared\Domain\ValueObject\Uuid;

final class VehicleBodyTypeFinder
{
    private VehicleBodyTypeRepository $repository;

    public function __construct(VehicleBodyTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id): VehicleBodyType
    {
        $id = new Uuid($id);

        $district = $this->repository->search($id);

        if (null === $district) {
            throw new VehicleBodyTypeNotExist($id);
        }

        return $district;
    }
}
