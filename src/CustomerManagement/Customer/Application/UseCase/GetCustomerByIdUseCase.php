<?php

namespace Src\CustomerManagement\Customer\Application\UseCase;

use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;
use Src\CustomerManagement\Customer\Domain\Entities\Customer;

final class GetCustomerByIdUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id)
    {
        return $this->repository->findById($id);
    }
}
