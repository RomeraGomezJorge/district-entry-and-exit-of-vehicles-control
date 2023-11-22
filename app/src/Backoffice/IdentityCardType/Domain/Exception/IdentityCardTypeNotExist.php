<?php

declare(strict_types=1);

namespace App\Backoffice\IdentityCardType\Domain\Exception;

use App\Shared\Domain\DomainError;

final class IdentityCardTypeNotExist extends DomainError
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Identity_card_type_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('El tipo de documento con el id "%s" no existe!', $this->id);
    }
}
