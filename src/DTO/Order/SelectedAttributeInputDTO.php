<?php

declare(strict_types=1);

namespace App\DTO\Order;

use Symfony\Component\Validator\Constraints as Assert;

class SelectedAttributeInputDTO
{
    /**
     * @Assert\Type(type="string", message="Attribute ID must be a string.")
     */
    private ?string $id;

    /**
     * @Assert\Type(type="string", message="Attribute value must be a string.")
     */
    private ?string $value;

    public function __construct(?string $id, ?string $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
