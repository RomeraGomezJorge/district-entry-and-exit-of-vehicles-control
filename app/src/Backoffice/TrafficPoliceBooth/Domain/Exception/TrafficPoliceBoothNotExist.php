<?php

declare(strict_types=1);

namespace App\Backoffice\TrafficPoliceBooth\Domain\Exception;

use App\Shared\Domain\DomainError;

final class TrafficPoliceBoothNotExist extends DomainError
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'traffic_police_booth_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('El puesto de control policial con el id "%s" no existe!', $this->id);
    }
}
