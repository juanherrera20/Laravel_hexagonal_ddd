<?php

namespace Src\CustomerManagement\Customer\Domain\ValueObjects;

final class CustomerName
{
    private string $name;

    public function __construct(string $name)
    {
        $name = trim($name);
        if (empty($name)) {
            throw new \InvalidArgumentException("El nombre no puede estar vacío");
        }
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
