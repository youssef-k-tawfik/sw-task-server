<?php

declare(strict_types=1);

namespace App\DTO\Order;

use App\DTO\ProductDTO;

class OrderItemDTO
{
    private ProductDTO $product;
    private int $quantity;
    /** @var array<int, array{ id: ?string, value: ?string }> */
    private array $selectedAttributes = [];

    public function __construct(ProductDTO $product, int $quantity, array $selectedAttributes = [])
    {
        $this->product            = $product;
        $this->quantity           = $quantity;
        $this->selectedAttributes = $selectedAttributes;
    }

    public function getProduct(): ProductDTO
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return array<int, array{ id: ?string, value: ?string }>
     */
    public function getSelectedAttributes(): array
    {
        return $this->selectedAttributes;
    }
}
