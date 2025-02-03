<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', name: 'order_number')]
    private string $orderNumber;

    #[ORM\Column(
        type: 'decimal',
        precision: 10,
        scale: 2,
        name: 'total_cost'
    )]
    private float $totalCost;

    #[ORM\Column(type: 'datetime', name: 'placed_at')]
    private \DateTimeInterface $placedAt;

    public function __construct()
    {
        $this->placedAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function setPlacedAt(\DateTimeInterface $placedAt): self
    {
        $this->placedAt = $placedAt;
        return $this;
    }

    public function getPlacedAt(): \DateTimeInterface
    {
        return $this->placedAt;
    }
}
