<?php

declare(strict_types=1);

namespace App\DTO\Order;

use Symfony\Component\Validator\Constraints as Assert;

class OrderItemInputDTO
{
    #[Assert\NotBlank(message: "Product ID should not be blank.")]
    #[Assert\Type(type: 'string', message: "Product ID must be a string.")]
    public  string $productId;

    #[Assert\NotNull(message: "Quantity should not be null.")]
    #[Assert\Positive(message: "Quantity must be a positive integer.")]
    #[Assert\Type(type: 'integer', message: "Quantity must be an integer.")]
    public int $quantity;

    /**
     * @var array<SelectedAttributeInputDTO>
     */
    #[Assert\NotNull(message: "Selected attributes should not be null.")]
    #[Assert\Valid]
    public array $selectedAttributes;

    /**
     * @param SelectedAttributeInputDTO[] $selectedAttributes
     */
    public function __construct(string $productId, int $quantity, array $selectedAttributes = [])
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->selectedAttributes = $selectedAttributes;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return SelectedAttributeInputDTO[]
     */
    public function getSelectedAttributes(): array
    {
        return $this->selectedAttributes;
    }
}
