<?php

namespace App\Backoffice\District\Domain;

use App\Backoffice\District\Domain\Exception\NonUniqueDistrictDescription;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;

class District extends AggregateRoot
{
    private $id;
    private $description;
    private $createAt;

    public static function create(
        Uuid                                   $id,
        string                                 $description,
        DateTime                               $createAt,
        UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification
    ): self
    {

        if (!$uniqueDistrictDescriptionSpecification->isSatisfiedBy($description)) {
            throw new NonUniqueDistrictDescription($description);
        }

        $district = new self();

        $district->id = $id;

        $district->description = $description;

        $district->createAt = $createAt;

        $district->record(new DistrictCreatedDomainEvent($id->value(), $description));

        return $district;
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
        string                                 $newDescription,
        UniqueDistrictDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void
    {
        if (StringUtils::equals($newDescription, $this->description)) {
            return;
        }

        if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($newDescription)) {
            throw new NonUniqueDistrictDescription($newDescription);
        }

        $this->description = $newDescription;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }
}
