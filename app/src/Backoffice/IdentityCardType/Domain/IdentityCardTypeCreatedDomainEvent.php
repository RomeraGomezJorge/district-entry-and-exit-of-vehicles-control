<?php

declare(strict_types=1);

namespace App\Backoffice\IdentityCardType\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class IdentityCardTypeCreatedDomainEvent extends DomainEvent
{
    private string $description;

    public function __construct(
        string $id,
        string $description,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);

        $this->description = $description;
    }

    public static function eventName(): string
    {
        return 'Identity_card_type.created';
    }

    public function description(): string
    {
        return $this->description;
    }
}
