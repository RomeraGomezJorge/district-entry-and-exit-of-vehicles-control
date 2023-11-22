<?php

namespace App\Backoffice\Role\Application\Find;

use App\Backoffice\Role\Domain\Exception\RoleNotExist;
use App\Backoffice\Role\Domain\Role;
use App\Backoffice\Role\Domain\RoleRepository;

final class RoleFinder
{
    private RoleRepository $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id): ?Role
    {
        $role = $this->repository->search($id);

        if (null === $role) {
            throw new RoleNotExist($id);
        }

        return $role;
    }
}
