<?php

declare(strict_types=1);

namespace App\DTO;

class ProductDTO
{
    private string $id;
    private string $name;
    private ?string $description;
    private ?bool $inStock;
    private string $brand;
    private string $category;
    /** @var string[] */
    private array $gallery;
    /** @var PriceDTO[] */
    private array $prices;
    /** @var AttributeSetDTO[] */
    private array $attributes;

    /**
     * @param string[]         $gallery
     * @param PriceDTO[]       $prices
     * @param AttributeSetDTO[] $attributes
     */
    public function __construct(
        string $id,
        string $name,
        ?string $description,
        ?bool $inStock,
        string $brand,
        string $category,
        array $gallery = [],
        array $prices = [],
        array $attributes = []
    ) {
        $this->id         = $id;
        $this->name       = $name;
        $this->description = $description;
        $this->inStock    = $inStock;
        $this->brand      = $brand;
        $this->category   = $category;
        $this->gallery    = $gallery;
        $this->prices     = $prices;
        $this->attributes = $attributes;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isInStock(): ?bool
    {
        return $this->inStock;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string[]
     */
    public function getGallery(): array
    {
        return $this->gallery;
    }

    /**
     * @return PriceDTO[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * @return AttributeSetDTO[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
