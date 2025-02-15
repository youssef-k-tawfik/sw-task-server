<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Repository\CurrencyRepository;
use App\Utils\CustomLogger;

class CurrencyResolver
{
    private CurrencyRepository $currencyRepository;
    private $currencies = [];

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getCurrency($root): array
    {
        try {
            $currencyId = $root['currencyId'];

            // if currency is already fetched, return it
            $currency = $this->currencies[$currencyId] ?? null;
            if ($currency) {
                return $currency;
            }

            $currency = $this->currencyRepository
                ->fetchCurrency($currencyId);

            if (!$currency) {
                throw new \Exception("Currency not found");
            }

            CustomLogger::debug($currency);
            // store currency in cache
            $this->currencies[$currencyId] = $currency;
            return $currency;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching currency: {$e->getMessage()}");
        }
    }
}
