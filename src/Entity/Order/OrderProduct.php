<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Product;
use App\Entity\Attribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'order_products')]
class OrderProduct
{
    #[ORM\Id]
    #[ORM\ManyToOne(
        targetEntity: Order::class,
        inversedBy: 'orderProducts'
    )]
    #[ORM\JoinColumn(
        name: 'order_id',
        referencedColumnName: 'id'
    )]
    private Order $order;

    #[ORM\Id]
    #[ORM\ManyToOne(
        targetEntity: Product::class
    )]
    #[ORM\JoinColumn(
        name: 'product_id',
        referencedColumnName: 'id'
    )]
    private Product $product;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\ManyToMany(
        targetEntity: Attribute::class,
        fetch: 'EAGER'
    )]
    #[ORM\JoinTable(
        name: 'order_product_attributes',
        joinColumns: [
            new ORM\JoinColumn(
                name: 'order_product_order_id',
                referencedColumnName: 'order_id'
            ),
            new ORM\JoinColumn(
                name: 'order_product_product_id',
                referencedColumnName: 'product_id'
            )
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'attribute_id', referencedColumnName: 'id')
        ]
    )]
    private Collection $selectedAttributes;

    public function __construct()
    {
        $this->selectedAttributes = new ArrayCollection();
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function addSelectedAttribute(Attribute $attribute): self
    {
        if (!$this->selectedAttributes->contains($attribute)) {
            $this->selectedAttributes[] = $attribute;
        }

        return $this;
    }

    public function removeSelectedAttribute(Attribute $attribute): self
    {
        $this->selectedAttributes->removeElement($attribute);

        return $this;
    }

    public function getSelectedAttributes(): Collection
    {
        return $this->selectedAttributes;
    }
}
