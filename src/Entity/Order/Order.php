<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer', name: 'order_number')]
    private string $orderNumber;

    #[ORM\Column(
        type: 'decimal',
        precision: 10,
        scale: 2,
        name: 'total_cost'
    )]
    private float $totalCost;

    #[ORM\Column(type: 'datetime', name: 'placed_at')]
    private \DateTimeInterface $placedAt;
}
