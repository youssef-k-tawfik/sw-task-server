<?php

declare(strict_types=1);

namespace App\Entity\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attribute_set')]
class AttributeSet
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $type;

    #[ORM\OneToMany(
        targetEntity: Attribute::class,
        mappedBy: 'attributeSet',
        fetch: 'EAGER'
    )]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function addItem(Attribute $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setAttributeSet($this);
        }

        return $this;
    }

    public function removeItem(Attribute $item): self
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }
}
