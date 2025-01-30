<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ProductCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(
        type: 'text',
        nullable: true
    )]
    private ?string $description;

    #[ORM\Column(
        type: 'boolean',
        name: 'in_stock'
    )]
    private bool $inStock;

    #[ORM\Column(type: 'string')]
    private string $brand;

    #[ORM\Column(
        type: 'string',
        enumType: ProductCategory::class
    )]
    private string $category;


    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setInStock(bool $inStock): self
    {
        $this->inStock = $inStock;
        return $this;
    }

    public function getInStock(): bool
    {
        return $this->inStock;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
