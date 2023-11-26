<?php

namespace App\Backoffice\VehicleBodyType\Application\Create;

use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class VehicleBodyTypeCreator
{
    private VehicleBodyTypeRepository $repository;

    private UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification;

    private EventBus $bus;

    public function __construct(
        VehicleBodyTypeRepository $repository,
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification,
        EventBus $bus
    ) {
        $this->repository                                    = $repository;
        $this->uniqueVehicleBodyTypeDescriptionSpecification = $uniqueVehicleBodyTypeDescriptionSpecification;
        $this->bus                                           = $bus;
    }

    public function __invoke(
        string $id,
        string $description,
        ?string $image
    ) {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $district = VehicleBodyType::create(
            $id,
            trim($description),
            trim($image),
            $createAt,
            $this->uniqueVehicleBodyTypeDescriptionSpecification
        );

        $this->repository->save($district);

        $this->bus->publish(...$district->pullDomainEvents());
    }
}
