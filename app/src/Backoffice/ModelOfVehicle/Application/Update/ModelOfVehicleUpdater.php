<?php

namespace App\Backoffice\ModelOfVehicle\Application\Update;

use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification as UniqueDescriptionSpecification;
use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;

final class ModelOfVehicleUpdater
{
    private ModelOfVehicleRepository $repository;
    private ModelOfVehicleFinder $finder;
    private VehicleBodyTypeFinder $finderVehicleBodyType;
    private VehicleMakerNameFinder $finderVehicleMakerName;
    private UniqueDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(
        ModelOfVehicleRepository $repository,
        UniqueDescriptionSpecification $uniqueDescriptionSpecification,
        VehicleMakerNameRepository $vehicleMakerNameRepository,
        VehicleBodyTypeRepository $vehicleBodyTypeRepository
    ) {
        $this->repository                     = $repository;
        $this->finder                         = new ModelOfVehicleFinder($repository);
        $this->finderVehicleMakerName         = new VehicleMakerNameFinder($vehicleMakerNameRepository);
        $this->finderVehicleBodyType          = new VehicleBodyTypeFinder($vehicleBodyTypeRepository);
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(
        string $id,
        string $newDescription,
        string $newVehicleMakerNameId,
        string $newVehicleBodyTypeId
    ): void {
        $modelOfVehicle       = $this->finder->__invoke($id);
        $newVehicleMakerName  = $this->finderVehicleMakerName->__invoke($newVehicleMakerNameId);
        $newVehicleBodyTypeId = $this->finderVehicleBodyType->__invoke($newVehicleBodyTypeId);

        $modelOfVehicle->changeDescription(
            trim($newDescription),
            $this->uniqueDescriptionSpecification
        );

        $modelOfVehicle->changeVehicleMakeName($newVehicleMakerName);

        $modelOfVehicle->changeVehicleBodyType($newVehicleBodyTypeId);

        $this->repository->save($modelOfVehicle);
    }
}
