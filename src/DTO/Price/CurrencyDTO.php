<?php

declare(strict_types=1);

namespace App\DTO\Price;

class CurrencyDTO
{
    private string $symbol;
    private string $label;

    public function __construct(string $symbol, string $label)
    {
        $this->symbol = $symbol;
        $this->label = $label;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
