<?php

declare(strict_types=1);

namespace App\Backoffice\ModelOfVehicle\Domain\Exception;

use App\Shared\Domain\DomainError;

final class ModelOfVehicleNameNotExist extends DomainError
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'model_of_vehicle_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('La modelo de vehiculo con el id "%s" no existe!', $this->id);
    }
}
