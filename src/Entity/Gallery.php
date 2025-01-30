<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'gallery')]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $url;

    public function getId(): int
    {
        return $this->id;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getURL(): string
    {
        return $this->url;
    }
}
