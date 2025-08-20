<?php

namespace Src\CustomerManagement\Customer\Domain\ValueObjects;

final class CustomerEmail
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido: $email");
        }
        $this->email = strtolower($email);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
