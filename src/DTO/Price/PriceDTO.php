<?php

declare(strict_types=1);

namespace App\DTO\Price;

class PriceDTO
{
    private float $amount;
    private CurrencyDTO $currency;

    public function __construct(float $amount, CurrencyDTO $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): CurrencyDTO
    {
        return $this->currency;
    }
}
