<?php

declare(strict_types=1);

namespace App\DTO\Order;

class OrderResponseDTO
{
    private string $orderNumber;
    /** @var OrderItemDTO[] */
    private array $orderItems = [];
    private float $totalCost;
    private string $placedAt;

    public function __construct(string $orderNumber, float $totalCost, string $placedAt)
    {
        $this->orderNumber = $orderNumber;
        $this->totalCost   = $totalCost;
        $this->placedAt    = $placedAt;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @return OrderItemDTO[]
     */
    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItemDTO $orderItem): void
    {
        $this->orderItems[] = $orderItem;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function getPlacedAt(): string
    {
        return $this->placedAt;
    }
}
