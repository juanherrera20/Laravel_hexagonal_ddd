<?php

namespace Src\CustomerManagement\Customer\Application\UseCase;

use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;

final class ListCustomersUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $filters = []): array
    {
        return $this->repository->list($filters);
    }
}
