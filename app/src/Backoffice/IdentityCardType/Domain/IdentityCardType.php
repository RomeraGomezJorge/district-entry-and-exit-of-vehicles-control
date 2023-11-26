<?php

namespace App\Backoffice\IdentityCardType\Domain;

use App\Backoffice\IdentityCardType\Domain\Exception\NonUniqueIdentityCardTypeDescription;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;

class IdentityCardType extends AggregateRoot
{
    private $id;
    private $description;
    private $createAt;

    public static function create(
        Uuid                                           $id,
        string                                         $description,
        DateTime                                       $createAt,
        UniqueIdentityCardTypeDescriptionSpecification $uniqueDescriptionSpecification
    ): self
    {

        if (!$uniqueDescriptionSpecification->isSatisfiedBy($description)) {
            throw new NonUniqueIdentityCardTypeDescription($description);
        }

        $identityCardType = new self();

        $identityCardType->id = $id;

        $identityCardType->description = $description;

        $identityCardType->createAt = $createAt;

        $identityCardType->record(new IdentityCardTypeCreatedDomainEvent($id->value(), $description));

        return $identityCardType;
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
        string                                         $newDescription,
        UniqueIdentityCardTypeDescriptionSpecification $uniqueDescriptionSpecification
    ): void
    {
        if (!StringUtils::equals($newDescription, $this->description)) {
            if (!$uniqueDescriptionSpecification->isSatisfiedBy($newDescription)) {
                throw new NonUniqueIdentityCardTypeDescription($newDescription);
            }

            $this->description = $newDescription;
        }
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }
}
