<?php

namespace App\Backoffice\User\Domain;

use App\Backoffice\Role\Domain\Role;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
use App\Backoffice\User\Domain\Exception\NonUniqueUserEmail;
use App\Backoffice\User\Domain\Exception\NonUniqueUserName;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot implements UserInterface, \Serializable
{
    private $id;
    private string $username;
    private string $name;
    private string $surname;
    private string $email;
    private string $password;
    private Role $role;
    private int $isActive;
    private DateTime $createAt;
    private DateTime $updateAt;
    private TrafficPoliceBooth $trafficPoliceBooth;

    public static function create(
        Uuid $id,
        string $username,
        string $name,
        string $surname,
        UserEmail $email,
        UserPassword $password,
        Role $role,
        int $isActive,
        TrafficPoliceBooth $trafficPoliceBooth,
        DateTime $createAt,
        UniqueUserNameSpecification $uniqueUserNameSpecification,
        UniqueUserEmailSpecification $uniqueUserEmailSpecification
    ): self {
        if (!$uniqueUserNameSpecification->isSatisfiedBy($username)) {
            throw new NonUniqueUserName($username);
        }

        if (!$uniqueUserEmailSpecification->isSatisfiedBy($email->value())) {
            throw new NonUniqueUserEmail($email->value());
        }

        $user                     = new self();
        $user->id                 = $id->value();
        $user->username           = $username;
        $user->name               = $name;
        $user->surname            = $surname;
        $user->email              = $email->value();
        $user->password           = $password->value();
        $user->role               = $role;
        $user->isActive           = (bool)$isActive;
        $user->trafficPoliceBooth = $trafficPoliceBooth;
        $user->createAt           = $createAt;
        $user->updateAt           = $createAt;

        $user->record(
            new UserCreatedDomainEvent(
                $id->value(),
                $username,
                $name,
                $surname,
                $email->value(),
                $password->value(),
                $role->getId(),
                $isActive,
                $trafficPoliceBooth->getId()
            )
        );

        return $user;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getIsActive(): int
    {
        return $this->isActive;
    }

    public function getTrafficPoliceBooth(): TrafficPoliceBooth
    {
        return $this->trafficPoliceBooth;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function changeUsername(
        string $newUsername,
        UniqueUserNameSpecification $uniqueUserNameSpecification
    ): void {
        if (!StringUtils::equals($newUsername, $this->username)) {
            if (!$uniqueUserNameSpecification->isSatisfiedBy($newUsername)) {
                throw new NonUniqueUserName($newUsername);
            }

            $this->username = $newUsername;
        }
    }

    public function changeName(string $newName): void
    {
        if (!StringUtils::equals($newName, $this->name)) {
            $this->name = $newName;
        }
    }

    public function changeSurname(string $newSurname): void
    {
        if (!StringUtils::equals($newSurname, $this->surname)) {
            $this->surname = $newSurname;
        }
    }

    public function changeEmail(
        UserEmail $newEmail,
        UniqueUserEmailSpecification $uniqueUserEmailSpecification
    ): void {
        if (!StringUtils::equals($newEmail->value(), $this->email)) {
            if (!$uniqueUserEmailSpecification->isSatisfiedBy($newEmail->value())) {
                throw new NonUniqueUserEmail($newEmail->value());
            }

            $this->email = $newEmail->value();
        }
    }

    public function setPassword(UserPassword $password): void
    {
        $this->password = $password->value();
    }

    public function setEncodedPassword(string $encodedPassword): void
    {
        $this->password = $encodedPassword;
    }

    public function changeRole(Role $newRole): void
    {
        if (!StringUtils::equals($newRole->getId(), $this->role->getId())) {
            $this->role = $newRole;
        }
    }

    public function changeIsActive(int $newStatus): void
    {
        $this->isActive = ($newStatus == $this->isActive);
    }

    public function changeTrafficPoliceBooth(TrafficPoliceBooth $newTrafficPoliceBooth)
    {
        if (!StringUtils::equals($newTrafficPoliceBooth->getId(), $this->trafficPoliceBooth->getId())) {
            $this->trafficPoliceBooth = $newTrafficPoliceBooth;
        }
    }

    public function setUpdateAt(DateTime $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    public function getRoles(): array
    {
        return array($this->role->getId());
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        /*
         *  meant to clean up possibly stored plain text passwords (or similar credentials).
         *  Be careful what to erase if your user class is also mapped to a database as the
         *  modified object will likely be persisted during the request.
         */
    }

    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->username,
                $this->password,
                $this->isActive
            ]
        );
    }

    public function unserialize($serialized)
    {
        list($this->id,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }
}
