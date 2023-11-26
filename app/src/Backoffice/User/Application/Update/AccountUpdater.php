<?php

namespace App\Backoffice\User\Application\Update;

use App\Backoffice\User\Application\Find\UserFinder;
use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
use App\Backoffice\User\Domain\UniqueUserNameSpecification;
use App\Backoffice\User\Domain\UserEmail;
use App\Backoffice\User\Domain\UserRepository;

final class AccountUpdater
{
    private UserRepository $repository;
    private UserFinder $finder;
    private UniqueUserNameSpecification $uniqueUserNameSpecification;
    private UniqueUserEmailSpecification $uniqueUserEmailSpecification;

    public function __construct(
        UserRepository $repository,
        UniqueUserNameSpecification $uniqueUserNameSpecification,
        UniqueUserEmailSpecification $uniqueUserEmailSpecification
    ) {
        $this->repository                   = $repository;
        $this->finder                       = new UserFinder($repository);
        $this->uniqueUserNameSpecification  = $uniqueUserNameSpecification;
        $this->uniqueUserEmailSpecification = $uniqueUserEmailSpecification;
    }

    public function __invoke(
        string $id,
        string $newUsername,
        string $newName,
        string $newSurname,
        string $newEmail
    ): void {
        $newEmail = new UserEmail(trim($newEmail));

        $user = $this->finder->__invoke($id);

        $user->changeUsername(trim($newUsername), $this->uniqueUserNameSpecification);

        $user->changeName(trim($newName));

        $user->changeSurname(trim($newSurname));

        $user->changeEmail($newEmail, $this->uniqueUserEmailSpecification);

        $user->setUpdateAt(new \DateTime());

        $this->repository->save($user);
    }
}
