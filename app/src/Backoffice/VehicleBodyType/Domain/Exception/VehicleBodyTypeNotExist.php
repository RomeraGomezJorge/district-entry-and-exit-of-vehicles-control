<?php

declare(strict_types=1);

namespace App\Backoffice\VehicleBodyType\Domain\Exception;

use App\Shared\Domain\DomainError;

final class VehicleBodyTypeNotExist extends DomainError
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'vehicle_body_type_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('El tipo de vehiculo con el id "%s" no existe!', $this->id);
    }
}
