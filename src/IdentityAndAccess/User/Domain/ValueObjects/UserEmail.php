<?php

namespace Src\IdentityAndAccess\User\Domain\ValueObjects;

use InvalidArgumentException;

class UserEmail
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El Correro $value no es es Valido!.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
