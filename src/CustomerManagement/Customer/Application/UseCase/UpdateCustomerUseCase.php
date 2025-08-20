<?php

namespace Src\CustomerManagement\Customer\Application\UseCase;

use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;
use Src\CustomerManagement\Customer\Domain\Entities\Customer;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;

final class UpdateCustomerUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id, string $name, string $email)
    {
        $customer = new Customer(
            new CustomerName($name),
            new CustomerEmail($email)
        );

        return $this->repository->update($id, $customer);
    }
}
