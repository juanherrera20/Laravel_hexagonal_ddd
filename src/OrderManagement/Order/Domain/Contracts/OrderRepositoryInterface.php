<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Domain\Contracts;

use Src\OrderManagement\Order\Domain\Entities\Order;

interface OrderRepositoryInterface
{
    public function create(Order $order): array;

    public function findById(int $id): ?Order;

    public function findByCustomerId(int $customerId): array;

    // public function calculateTotalCustomerById(int $customerId): Collection; // No es Necesario, para esta tarea se puede usar findByCustomer

    public function delete(int $id): bool;

}