<?php

namespace App\Backoffice\VehicleMakerName\Application\Create;

use App\Backoffice\VehicleMakerName\Domain\UniqueVehicleMakerNameDescriptionSpecification;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class VehicleMakerNameCreator
{
    private VehicleMakerNameRepository $repository;

    private UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification;

    private EventBus $bus;

    public function __construct(
        VehicleMakerNameRepository                     $repository,
        UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification,
        EventBus                                       $bus
    )
    {
        $this->repository                                     = $repository;
        $this->uniqueVehicleMakerNameDescriptionSpecification = $uniqueVehicleMakerNameDescriptionSpecification;
        $this->bus                                            = $bus;
    }

    public function __invoke(string $id, string $description)
    {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $district = VehicleMakerName::create(
            $id,
            trim($description),
            $createAt,
            $this->uniqueVehicleMakerNameDescriptionSpecification
        );

        $this->repository->save($district);

        $this->bus->publish(...$district->pullDomainEvents());
    }
}
