<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class UserCreatedDomainEvent extends DomainEvent
{
    private string $username;
    private string $name;
    private string $surname;
    private string $email;
    private string $password;
    private string $role;
    private string $isActive;
    private string $trafficPoliceBooth;

    public function __construct(
        string $id,
        string $description,
        string $name,
        string $surname,
        string $email,
        string $password,
        string $role,
        string $isActive,
        string $trafficPoliceBooth,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->username           = $description;
        $this->name               = $name;
        $this->surname            = $surname;
        $this->email              = $email;
        $this->password           = $password;
        $this->role               = $role;
        $this->isActive           = $isActive;
        $this->trafficPoliceBooth = $trafficPoliceBooth;
    }

    public static function eventName(): string
    {
        return 'user.created';
    }

    public function username(): string
    {
        return $this->username;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function isActive(): string
    {
        return $this->isActive;
    }

    public function trafficPoliceBooth(): string
    {
        return $this->trafficPoliceBooth;
    }
}
