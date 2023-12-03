<?php

namespace App\Backoffice\IdentityCardType\Application\Update;

use App\Backoffice\IdentityCardType\Application\Find\IdentityCardTypeFinder;
use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification as UniqueDescriptionSpecification;

final class IdentityCardTypeUpdater
{
    private IdentityCardTypeRepository $repository;
    private IdentityCardTypeFinder $finder;
    private UniqueDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(
        IdentityCardTypeRepository $repository,
        UniqueDescriptionSpecification $uniqueDescriptionSpecification
    ) {
        $this->repository                     = $repository;
        $this->finder                         = new IdentityCardTypeFinder($repository);
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(string $id, string $newDescription): void
    {
        $identityCardType = $this->finder->__invoke($id);

        $identityCardType->changeDescription(
            trim($newDescription),
            $this->uniqueDescriptionSpecification
        );

        $this->repository->save($identityCardType);
    }
}
