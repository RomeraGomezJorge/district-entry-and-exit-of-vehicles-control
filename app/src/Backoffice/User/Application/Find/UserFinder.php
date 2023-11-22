<?php

namespace App\Backoffice\User\Application\Find;

use App\Backoffice\User\Domain\Exception\UserNotExist;
use App\Backoffice\User\Domain\User;
use App\Backoffice\User\Domain\UserRepository;
use App\Shared\Domain\ValueObject\Uuid;

final class UserFinder
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id): ?User
    {
        $id = new Uuid($id);

        $user = $this->repository->search($id);

        if (null === $user) {
            throw new UserNotExist($id);
        }

        return $user;
    }
}
