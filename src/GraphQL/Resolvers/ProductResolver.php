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
            $productId = $args['id'] ?? null;

            // CustomLogger::debug($category);
            if ($category) {
                CustomLogger::logInfo("Fetching '{$category}' category products");
            } else if ($productId) {
                CustomLogger::logInfo("Fetching '{$productId}' product data");
            } else {
                CustomLogger::logInfo("Fetching all products data");
            }

            $products = $this->productService
                ->getAllProducts($category, $productId);
            return $products;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching products: {$e->getMessage()}");
        }
    }
}
