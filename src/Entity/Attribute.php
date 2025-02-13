<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Order\OrderProduct;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attribute')]
class Attribute
{
    // adding identifier to store same id with different identifier
    // for "yes" and "no" attributes
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private string $identifier;

    #[ORM\Column(type: 'string', length: 255)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $value;

    #[ORM\Column(
        type: 'string',
        name: 'display_value'
    )]
    private string $displayValue;

    #[ORM\ManyToOne(
        targetEntity: AttributeSet::class,
        inversedBy: 'items',
        fetch: 'EAGER'
    )]
    #[ORM\JoinColumn(
        name: 'attribute_set_id',
        referencedColumnName: 'id',
        nullable: false
    )]
    private AttributeSet $attributeSet;

    #[ORM\ManyToMany(
        targetEntity: Product::class,
        mappedBy: 'attributes'
    )]
    private Collection $products;

    #[ORM\ManyToMany(
        targetEntity: OrderProduct::class,
        mappedBy: 'selectedAttributes'
    )]
    private Collection $orderedProducts;

    public function __construct()
    {
        $this->orderedProducts = new ArrayCollection();
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setDisplayValue(string $displayValue): self
    {
        $this->displayValue = $displayValue;
        return $this;
    }

    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    public function setAttributeSet(AttributeSet $attributeSet): self
    {
        $this->attributeSet = $attributeSet;
        return $this;
    }

    public function getAttributeSet(): AttributeSet
    {
        return $this->attributeSet;
    }

    public function addOrderedProduct(OrderProduct $orderedProduct): self
    {
        $this->orderedProducts[] = $orderedProduct;
        return $this;
    }

    public function removeOrderedProduct(OrderProduct $orderedProduct): self
    {
        $this->orderedProducts->removeElement($orderedProduct);
        return $this;
    }

    public function getOrderedProducts(): Collection
    {
        return $this->orderedProducts;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}
