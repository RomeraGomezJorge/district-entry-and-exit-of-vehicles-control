<?php

namespace App\Backoffice\Role\Infrastructure\Persistence;

use App\Backoffice\Role\Domain\Role;
use App\Backoffice\Role\Domain\RoleRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlRoleRepository extends DoctrineRepository implements RoleRepository
{
    public function save(Role $role): void
    {
        $this->persist($role);
    }

    public function search($id): ?Role
    {
        return $this->repository(Role::class)->find($id);
    }

    public function searchAll(): array
    {
        return $this->repository(Role::class)->findAll();
    }
}
