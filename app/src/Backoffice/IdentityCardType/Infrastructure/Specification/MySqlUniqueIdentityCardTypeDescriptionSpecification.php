<?php

declare(strict_types=1);

namespace App\Backoffice\IdentityCardType\Infrastructure\Specification;

use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification;
use App\Backoffice\IdentityCardType\Infrastructure\Persistence\MySqlIdentityCardTypeRepository;

final class MySqlUniqueIdentityCardTypeDescriptionSpecification implements UniqueIdentityCardTypeDescriptionSpecification
{
    private MySqlIdentityCardTypeRepository $repository;

    public function __construct(MySqlIdentityCardTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isSatisfiedBy(string $description): bool
    {
        return !$this->repository->isDescriptionExits($description);
    }
}
