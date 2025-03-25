<?php

declare(strict_types=1);

namespace App\DTO\Attribute;

class AttributeSetDTO
{
    private string $id;
    private string $name;
    private string $type;
    /** @var AttributeDTO[] */
    private array $items;

    /**
     * @param AttributeDTO[] $items
     */
    public function __construct(string $id, string $name, string $type, array $items = [])
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->type  = $type;
        $this->items = $items;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return AttributeDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
