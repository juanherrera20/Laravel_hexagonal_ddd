<?php

namespace Src\CustomerManagement\Customer\Application\UseCase;

use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;

final class DeleteCustomerUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
