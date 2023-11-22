<?php

namespace App\Backoffice\Role\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;

class Role extends AggregateRoot
{
    private $id;
    private $description;


    public static function create(
        string $id,
        string $description
    ): self
    {

        $role              = new self();
        $role->id          = $id;
        $role->description = $description;

        return $role;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
