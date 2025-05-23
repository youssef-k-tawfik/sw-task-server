<?php

declare(strict_types=1);

namespace App\Entity\Price;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'price')]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(
        type: 'decimal',
        precision: 10,
        scale: 2
    )]
    private float $amount;

    #[ORM\ManyToOne(
        targetEntity: Currency::class,
        inversedBy: 'prices',
        cascade: ['persist'],
        fetch: 'EAGER'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private Currency $currency;

    #[ORM\ManyToOne(
        targetEntity: Product::class,
        inversedBy: 'prices'
    )]
    #[ORM\JoinColumn(
        name: 'product_id',
        referencedColumnName: 'id',
        nullable: false
    )]
    private Product $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
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
}
