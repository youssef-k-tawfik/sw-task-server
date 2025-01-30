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

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'boolean', name: 'in_stock')]
    private bool $inStock;

    #[ORM\Column(type: 'string')]
    private string $brand;

    #[ORM\Column(
        type: 'string',
        enumType: ProductCategory::class
    )]
    private string $category;
}
