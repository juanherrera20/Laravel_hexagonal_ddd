<?php

namespace Src\CustomerManagement\Customer\Application\UseCase;

use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;
use Src\CustomerManagement\Customer\Domain\Entities\Customer;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;

final class CreateCustomerUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $email): int
    {
        $customer = new Customer(
            new CustomerName($name),
            new CustomerEmail($email)
        );

        return $this->repository->create($customer);
    }
}
