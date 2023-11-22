<?php

declare(strict_types=1);

namespace App\Backoffice\District\Domain\Exception;

use App\Shared\Domain\DomainError;

final class DistrictNotExist extends DomainError
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'district_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('La provincia  con el id "%s" no existe!', $this->id);
    }
}
