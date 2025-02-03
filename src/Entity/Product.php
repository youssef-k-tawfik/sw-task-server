<?php

declare(strict_types=1);

namespace App\Entity;

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

    #[ORM\ManyToOne(
        targetEntity: Category::class,
        inversedBy: 'products',
        fetch: 'EAGER'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\OneToMany(
        targetEntity: Gallery::class,
        mappedBy: 'product',
        cascade: ['persist', 'remove'],
        fetch: 'EAGER'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $gallery;

    #[ORM\OneToMany(
        targetEntity: Price::class,
        mappedBy: 'product',
        cascade: ['persist', 'remove'],
        fetch: 'EAGER'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $prices;

    #[ORM\OneToMany(
        targetEntity: AttributeSet::class,
        mappedBy: 'products',
        fetch: 'EAGER'
    )]
    private Collection $attributeSets;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->attributeSets = new ArrayCollection();
    }

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

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function addGallery(Gallery $gallery): self
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery[] = $gallery;
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): self
    {
        $this->gallery->removeElement($gallery);

        return $this;
    }

    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        $this->prices->removeElement($price);

        return $this;
    }

    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addAttributeSet(AttributeSet $attributeSet): self
    {
        if (!$this->attributeSets->contains($attributeSet)) {
            $this->attributeSets[] = $attributeSet;
        }

        return $this;
    }

    public function removeAttributeSet(AttributeSet $attributeSet): self
    {
        $this->attributeSets->removeElement($attributeSet);

        return $this;
    }

    public function getAttributeSets(): Collection
    {
        return $this->attributeSets;
    }
}
