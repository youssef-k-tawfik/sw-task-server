<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Repository\PriceRepository;
use App\Utils\CustomLogger;

class PriceResolver
{
    private PriceRepository $priceRepository;

    public function __construct(PriceRepository $PriceRepository)
    {
        $this->priceRepository = $PriceRepository;
    }

    public function getAllPrices($root): array
    {
        try {
            $productID = $root['id'] ?? null;
            if (!$productID) {
                throw new \Exception("Product ID is required");
            }

            $prices = $this->priceRepository->fetchAllPrices($productID);
            CustomLogger::debug($prices);
            return $prices;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching prices: {$e->getMessage()}");
        }
    }
}
