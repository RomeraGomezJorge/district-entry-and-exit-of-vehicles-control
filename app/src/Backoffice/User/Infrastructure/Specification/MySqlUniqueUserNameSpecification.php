<?php

declare(strict_types=1);

namespace App\Backoffice\User\Infrastructure\Specification;

use App\Backoffice\User\Domain\UniqueUserNameSpecification;
use App\Backoffice\User\Infrastructure\Persistence\MySqlUserRepository;

final class MySqlUniqueUserNameSpecification implements UniqueUserNameSpecification
{
    private MySqlUserRepository $repository;

    public function __construct(MySqlUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isSatisfiedBy(string $username): bool
    {
        return !$this->repository->isUserNameExits(array('username' => $username));
    }
}
