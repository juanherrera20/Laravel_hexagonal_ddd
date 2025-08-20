<?php

namespace Src\CustomerManagement\Customer\Domain\Entities;

use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;

final class Customer
{
    private CustomerName $name;
    private CustomerEmail $email;

    public function __construct(CustomerName $name, CustomerEmail $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function name(): CustomerName
    {
        return $this->name;
    }

    public function email(): CustomerEmail
    {
        return $this->email;
    }
}
