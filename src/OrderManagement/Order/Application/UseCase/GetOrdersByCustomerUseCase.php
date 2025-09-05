<?php

declare(strict_types=1);

namespace Src\OrderManagement\Order\Application\UseCase;

use Src\OrderManagement\Order\Domain\Contracts\OrderRepositoryInterface;

final class GetOrdersByCustomerUseCase
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $customerIdValue): array
    {
        return $this->orderRepository->findByCustomerId($customerIdValue);

    }

}
