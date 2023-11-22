<?php

namespace App\Backoffice\ModelOfVehicle\Domain;

use App\Backoffice\ModelOfVehicle\Domain\Exception\NonUniqueModelOfVehicleDescription;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;

class ModelOfVehicle extends AggregateRoot
{
    private $id;
    private string $description;
    private DateTime $createAt;
    private VehicleMakerName $vehicleMakerName;
    private VehicleBodyType $vehicleBodyType;

    public static function create(
        Uuid                                         $id,
        string                                       $description,
        VehicleMakerName                             $vehicleMakerName,
        VehicleBodyType                              $vehicleBodyType,
        DateTime                                     $createAt,
        UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification
    ): self
    {
        if (
            !$uniqueModelOfVehicleDescriptionSpecification->isSatisfiedBy(
                $description,
                $vehicleMakerName->getId()
            )
        ) {
            throw new NonUniqueModelOfVehicleDescription($description);
        }

        $modelOfVehicle = new self();

        $modelOfVehicle->id = $id;

        $modelOfVehicle->description = $description;

        $modelOfVehicle->vehicleMakerName = $vehicleMakerName;

        $modelOfVehicle->vehicleBodyType = $vehicleBodyType;

        $modelOfVehicle->createAt = $createAt;

        $modelOfVehicle->record(new ModelOfVehicleCreatedDomainEvent(
            $id->value(),
            $description,
            $vehicleMakerName->getId(),
            $vehicleBodyType->getId()
        ));

        return $modelOfVehicle;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function changeDescription(
        string                                       $newDescription,
        UniqueModelOfVehicleDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void
    {
        if (StringUtils::equals($newDescription, $this->description)) {
            return;
        }

        if (
            !$uniqueTagDescriptionSpecification->isSatisfiedBy(
                $newDescription,
                $this->geTVehicleMakerName()->getId()
            )
        ) {
            throw new NonUniqueModelOfVehicleDescription($newDescription);
        }

        $this->description = $newDescription;
    }

    public function geTVehicleMakerName(): VehicleMakerName
    {
        return $this->vehicleMakerName;
    }

    public function changeVehicleMakeName(VehicleMakerName $vehicleMakeName)
    {
        if (StringUtils::equals($vehicleMakeName->getId(), $this->vehicleMakerName->getId())) {
            return;
        }

        $this->vehicleMakerName = $vehicleMakeName;
    }

    public function getVehicleBodyType(): VehicleBodyType
    {
        return $this->vehicleBodyType;
    }

    public function changeVehicleBodyType(VehicleBodyType $newVehicleBodyType): void
    {
        if (StringUtils::equals($newVehicleBodyType->getId(), $this->vehicleBodyType->getId())) {
            return;
        }

        $this->vehicleBodyType = $newVehicleBodyType;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }
}
