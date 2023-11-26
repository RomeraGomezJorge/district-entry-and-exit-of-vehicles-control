<?php

namespace App\Backoffice\IdentityCardType\Application\Create;

use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class IdentityCardTypeCreator
{
    private IdentityCardTypeRepository $repository;
    private UniqueIdentityCardTypeDescriptionSpecification $uniqueDescriptionSpecification;
    private EventBus $bus;

    public function __construct(
        IdentityCardTypeRepository                     $repository,
        UniqueIdentityCardTypeDescriptionSpecification $uniqueDescriptionSpecification,
        EventBus                                       $bus
    )
    {
        $this->repository                     = $repository;
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
        $this->bus                            = $bus;
    }

    public function __invoke(string $id, string $description)
    {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $identityCardType = IdentityCardType::create(
            $id,
            trim($description),
            $createAt,
            $this->uniqueDescriptionSpecification
        );

        $this->repository->save($identityCardType);

        $this->bus->publish(...$identityCardType->pullDomainEvents());
    }
}
