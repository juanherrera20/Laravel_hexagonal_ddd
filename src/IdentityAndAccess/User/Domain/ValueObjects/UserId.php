<?php 

namespace Src\IdentityAndAccess\User\Domain\ValueObjects;

use InvalidArgumentException;

class UserId
{

    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0){
            throw new InvalidArgumentException("El ID debe ser un numero mayor a 0");
        }

        $this->value = $value;
    }


    public function value(): int
    {
        return $this->value;
    }
}

