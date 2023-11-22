<?php

namespace App\Backoffice\User\Domain;

use App\Backoffice\User\Domain\Exception\UserEmailInvalid;
use InvalidArgumentException;

final class UserEmail
{
    private string $email;
    private string $domain;
    private string $localPart;


    public function __construct(string $anEmail)
    {
        if (!filter_var($anEmail, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('El el correo electronico "%s" que ha ingresado no es válido.', $anEmail));
        }
        $this->email     = $anEmail;
        $this->localPart = implode(explode('@', $this->email, -1), '@');
        $this->domain    = str_replace($this->localPart . '@', '', $this->email);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function localPart(): string
    {
        return $this->localPart;
    }

    public function domain(): string
    {
        return $this->domain;
    }
}
