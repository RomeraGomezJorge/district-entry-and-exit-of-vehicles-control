<?php

namespace App\Backoffice\IdentityCardType\Application\Delete;

use App\Backoffice\IdentityCardType\Application\Find\IdentityCardTypeFinder;
use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;

final class IdentityCardTypeDeleter
{
    private IdentityCardTypeRepository $repository;
    private IdentityCardTypeFinder $finder;

    public function __construct(
        IdentityCardTypeRepository $repository
    ) {
        $this->repository = $repository;
        $this->finder     = new IdentityCardTypeFinder($repository);
    }

    public function __invoke(string $id)
    {
        $district = $this->finder->__invoke($id);

        $this->repository->delete($district);
    }
}
