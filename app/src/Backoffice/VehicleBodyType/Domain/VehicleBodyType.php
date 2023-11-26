<?php

namespace App\Backoffice\VehicleBodyType\Domain;

use App\Backoffice\VehicleBodyType\Domain\Exception\NonUniqueVehicleBodyTypeDescription;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;

class VehicleBodyType extends AggregateRoot
{
    private $id;

    private $description;

    private $image;

    private $createAt;

    public static function create(
        Uuid $id,
        string $description,
        ?string $image,
        DateTime $createAt,
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification
    ): self {
        if (!$uniqueVehicleBodyTypeDescriptionSpecification->isSatisfiedBy($description)) {
            throw new NonUniqueVehicleBodyTypeDescription($description);
        }

        $vehicleBodyType = new self();

        $vehicleBodyType->id = $id;

        $vehicleBodyType->description = $description;

        $vehicleBodyType->image = $image;

        $vehicleBodyType->createAt = $createAt;

        $vehicleBodyType->record(new VehicleBodyTypeCreatedDomainEvent($id->value(), $description));

        return $vehicleBodyType;
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

    public function setDescription(
        string $newDescription,
        UniqueVehicleBodyTypeDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void {
        if (!StringUtils::equals($newDescription, $this->description)) {
            if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($newDescription)) {
                throw new NonUniqueVehicleBodyTypeDescription($newDescription);
            }

            $this->description = $newDescription;
        }
    }

    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function changeImage(?string $newImage): void
    {
        if (!StringUtils::equals($newImage, $this->image)) {
            $this->image = $newImage;
        }
    }
}
