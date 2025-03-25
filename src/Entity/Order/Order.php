<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, name: 'order_number')]
    private string $orderNumber;

    #[ORM\Column(
        type: 'decimal',
        precision: 10,
        scale: 2,
        name: 'total_cost'
    )]
    private float $totalCost;

    #[ORM\Column(type: 'datetime', name: 'placed_at')]
    private \DateTime $placedAt;


    #[ORM\OneToMany(
        targetEntity: OrderProduct::class,
        mappedBy: 'order',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $orderProducts;

    public function __construct()
    {
        $this->placedAt = new \DateTime();
        $this->orderProducts = new ArrayCollection();
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
        if ($totalCost <= 0) {
            throw new \InvalidArgumentException('Total cost must be a positive number.');
        }

        $this->totalCost = $totalCost;
        return $this;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function setPlacedAt(\DateTime $placedAt): self
    {
        $this->placedAt = $placedAt;
        return $this;
    }

    public function getPlacedAt(): \DateTime
    {
        return $this->placedAt;
    }

    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setOrder($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrder() === $this) {
                $orderProduct->setOrder(null);
            }
        }

        return $this;
    }
}
