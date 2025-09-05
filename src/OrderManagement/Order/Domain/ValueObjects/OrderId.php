<?php 

declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

class OrderId
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

