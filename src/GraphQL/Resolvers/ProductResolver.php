<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Service\ProductService;
use App\Utils\CustomLogger;

class ProductResolver
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts($root, $args): array
    {
        try {
            $category = $args['category'] ?? null;
            // CustomLogger::debug($category);
            CustomLogger::logInfo("Fetching " . ($category ?? "all") . " products");
            $products = $this->productService->getAllProducts($category);
            return $products;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching products: {$e->getMessage()}");
        }
    }
}
