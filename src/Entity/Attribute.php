<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attribute')]
class Attribute
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string')]
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
    #[ORM\JoinColumn(nullable: false)]
    private AttributeSet $attributeSet;

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
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
}
