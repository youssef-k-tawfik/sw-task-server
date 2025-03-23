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

    /**
     * Fetches the dates of the given orders.
     *
     * @param array $orders
     * @return array
     */
    public function getDates(array $orders): array
    {
        return $this->orderRepository->getDates($orders);
    }


    /**
     * Retrieves an order by order number and maps it to a GraphQL response DTO.
     *
     * @param string $orderNumber
     * @return OrderResponseType
     * @throws Exception
     */
    // public function getOrder(string $orderNumber): OrderResponseType
    // {
    //     // Retrieve the fully hydrated Order entity.
    //     $orderEntity = $this->orderRepository->getOrder($orderNumber);

    //     // Map the domain Order entity to a GraphQL response object.
    //     $orderResponse = new OrderResponseType();
    //     $orderResponse->orderNumber = $orderEntity->getOrderNumber();
    //     $orderResponse->totalCost = $orderEntity->getTotalCost();
    //     $orderResponse->placedAt = $orderEntity->getPlacedAt()->format('d M Y');

    //     // Map each OrderProduct to an OrderItem.
    //     foreach ($orderEntity->getOrderProducts() as $orderProduct) {
    //         $orderItem = new OrderItemType();
    //         $orderItem->product = $orderProduct->getProduct(); // You might further map Product if needed.
    //         $orderItem->quantity = $orderProduct->getQuantity();

    //         // Map selected attributes from the order product.
    //         $selectedAttributes = [];
    //         foreach ($orderProduct->getSelectedAttributes() as $attribute) {
    //             $selectedAttributes[] = [
    //                 'id'    => $attribute->getId(),
    //                 'value' => $attribute->getValue()
    //             ];
    //         }
    //         $orderItem->selectedAttributes = $selectedAttributes;

    //         $orderResponse->orderItems[] = $orderItem;
    //     }

    //     return $orderResponse;
    // }
}
