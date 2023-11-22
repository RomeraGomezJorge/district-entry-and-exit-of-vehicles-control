<?php

declare(strict_types=1);

namespace App\Backoffice\ReasonForTrip\Domain\Exception;

use App\Shared\Domain\DomainError;

final class ReasonForTripNotExist extends DomainError
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'reason_for_trip_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('El motivo de viaje con el id "%s" no existe!', $this->id);
    }
}
