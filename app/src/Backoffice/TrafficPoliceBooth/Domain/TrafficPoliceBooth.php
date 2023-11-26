<?php

namespace App\Backoffice\TrafficPoliceBooth\Domain;

use App\Backoffice\TrafficPoliceBooth\Domain\Exception\NonUniqueTrafficPoliceBoothDescription;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;

class TrafficPoliceBooth extends AggregateRoot
{
    private $id;
    private $description;
    private $createAt;

    public static function create(
        Uuid $id,
        string $description,
        DateTime $createAt,
        UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification
    ): self {

        if (!$uniqueTrafficPoliceBoothDescriptionSpecification->isSatisfiedBy($description)) {
            throw new NonUniqueTrafficPoliceBoothDescription($description);
        }

        $trafficPoliceBooth = new self();

        $trafficPoliceBooth->id = $id;

        $trafficPoliceBooth->description = $description;

        $trafficPoliceBooth->createAt = $createAt;

        $trafficPoliceBooth->record(new TrafficPoliceBoothCreatedDomainEvent($id->value(), $description));

        return $trafficPoliceBooth;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function changeDescription(
        string $newDescription,
        UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTagDescriptionSpecification
    ): void {
        if (!StringUtils::equals($newDescription, $this->description)) {
            if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($newDescription)) {
                throw new NonUniqueTrafficPoliceBoothDescription($newDescription);
            }

            $this->description = $newDescription;
        }
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }
}
