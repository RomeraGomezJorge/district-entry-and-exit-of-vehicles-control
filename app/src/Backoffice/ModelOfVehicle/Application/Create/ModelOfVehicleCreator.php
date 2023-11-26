<?php

namespace App\Backoffice\ModelOfVehicle\Application\Create;

use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class ModelOfVehicleCreator
{
    private ModelOfVehicleRepository $repository;

    private VehicleMakerNameFinder $finderVehicleMakerName;

    private UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification;

    private EventBus $bus;

    private VehicleBodyTypeFinder $finderVehicleBodyType;

    public function __construct(
        ModelOfVehicleRepository $repository,
        VehicleMakerNameRepository $vehicleMakerNameRepository,
        VehicleBodyTypeRepository $vehicleBodyTypeRepository,
        UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification,
        EventBus $bus
    ) {
        $this->repository                                   = $repository;
        $this->finderVehicleMakerName                       = new VehicleMakerNameFinder($vehicleMakerNameRepository);
        $this->finderVehicleBodyType                        = new VehicleBodyTypeFinder($vehicleBodyTypeRepository);
        $this->uniqueModelOfVehicleDescriptionSpecification = $uniqueModelOfVehicleDescriptionSpecification;
        $this->bus                                          = $bus;
    }

    public function __invoke(
        string $id,
        string $description,
        string $vehicleMakerNameId,
        string $vehicleBodyTypeId
    ) {
        $id = new Uuid($id);

        $vehicleMakerName = $this->finderVehicleMakerName->__invoke(new Uuid($vehicleMakerNameId));

        $vehicleBodyType = $this->finderVehicleBodyType->__invoke(new Uuid($vehicleBodyTypeId));

        $createAt = new \DateTime();

        $modelOfVehicle = ModelOfVehicle::create(
            $id,
            trim($description),
            $vehicleMakerName,
            $vehicleBodyType,
            $createAt,
            $this->uniqueModelOfVehicleDescriptionSpecification
        );

        $this->repository->save($modelOfVehicle);

        $this->bus->publish(...$modelOfVehicle->pullDomainEvents());
    }
}
