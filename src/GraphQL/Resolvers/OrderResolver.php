<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Service\OrderService;
use App\Utils\CustomLogger;

class OrderResolver
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function placeOrder($root, $args): array
    {
        CustomLogger::logInfo("Received orderItems: " . print_r($args["orderItems"], true));

        $order = $this->orderService->placeOrder($args['orderItems']);

        return ["order_number" => $order->getOrderNumber()];
    }

    public function getDates($root, $args): array
    {
        return $this->orderService->getDates($args['orders']);
    }

    // public function getOrder($root, $args): array
    // {
    //     return $this->orderService->getOrder($args['orderNumber']);
    // }
}
