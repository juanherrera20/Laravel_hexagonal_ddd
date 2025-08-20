<?php

namespace Src\CustomerManagement\Customer\Domain\Contracts;

use Src\CustomerManagement\Customer\Domain\Entities\Customer;

interface CustomerRepositoryInterface
{

    public function create(Customer $customer);

    public function findById(int $id);

    public function list(array $filters = []): array;

    public function update(int $id, Customer $customer);

    public function delete(int $id): bool;
}
