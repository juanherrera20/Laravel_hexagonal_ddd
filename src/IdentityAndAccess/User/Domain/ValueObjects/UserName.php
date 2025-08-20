<?php

namespace Src\IdentityAndAccess\User\Domain\ValueObjects;

use InvalidArgumentException;

class UserName
{
    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 5) {
            throw new InvalidArgumentException("El nombre del usuario debe tener al menos 5 caracteres.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
