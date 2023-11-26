<?php

namespace App\Backoffice\VehicleBodyType\Application\Update;

use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;

final class VehicleBodyTypeUpdater
{
    private VehicleBodyTypeRepository $repository;

    private VehicleBodyTypeFinder $finder;

    private UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification;

    public function __construct(
        VehicleBodyTypeRepository $repository,
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification
    ) {
        $this->repository                                    = $repository;
        $this->finder                                        = new VehicleBodyTypeFinder($repository);
        $this->uniqueVehicleBodyTypeDescriptionSpecification = $uniqueVehicleBodyTypeDescriptionSpecification;
    }

    public function __invoke(
        string $id,
        string $newDescription,
        ?string $newImage
    ): void {
        $vehicleBodyType = $this->finder->__invoke($id);

        $vehicleBodyType->setDescription(
            trim($newDescription),
            $this->uniqueVehicleBodyTypeDescriptionSpecification
        );

        $vehicleBodyType->changeImage(trim($newImage));

        $this->repository->save($vehicleBodyType);
    }
}
