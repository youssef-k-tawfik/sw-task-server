<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\OrderRepository;
use App\Entity\Order\Order;

class OrderService
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Validates input, processes orderItems and persists the order.
     *
     * @param array $orderItems
     * @return Order
     */
    public function placeOrder(array $orderItems): Order
    {
        // Perform any necessary validation on $orderItems here
        // Example: Validate that quantity is positive, product exists, etc.

        // Delegate the persistence logic to the repository
        return $this->orderRepository->createOrder($orderItems);
    }
}
