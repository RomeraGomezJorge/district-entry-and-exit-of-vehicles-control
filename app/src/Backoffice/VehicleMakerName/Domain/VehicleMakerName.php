<?php

namespace App\Backoffice\VehicleMakerName\Domain;

use App\Backoffice\VehicleMakerName\Domain\Exception\NonUniqueVehicleMakerNameDescription;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;

class VehicleMakerName extends AggregateRoot
{
    private string $id;
    private string $description;
    private DateTime $createAt;

    public static function create(
        Uuid $id,
        string $description,
        DateTime $createAt,
        UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification
    ): self {

        if (!$uniqueVehicleMakerNameDescriptionSpecification->isSatisfiedBy($description)) {
            throw new NonUniqueVehicleMakerNameDescription($description);
        }

        $vehicleMakerName = new self();

        $vehicleMakerName->id = $id;

        $vehicleMakerName->description = $description;

        $vehicleMakerName->createAt = $createAt;

        $vehicleMakerName->record(new VehicleMakerNameCreatedDomainEvent($id->value(), $description));

        return $vehicleMakerName;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function changeDescription(
        string $newDescription,
        UniqueVehicleMakerNameDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void {
        if (!Stringutils::equals($newDescription, $this->description)) {
            if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($newDescription)) {
                throw new NonUniqueVehicleMakerNameDescription($newDescription);
            }

            $this->description = $newDescription;
        }
    }

    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }
}
