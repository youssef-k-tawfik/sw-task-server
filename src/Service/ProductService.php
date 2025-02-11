<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProductRepository;
use App\Utils\CustomLogger;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(?string $category = null): array
    {
        try {
            $products = $this->productRepository->getAllProducts($category);

            if (!$products) {
                throw new \Exception("Products not found");
            }

            $products = $this->mapGallery($products);

            // CustomLogger::debug($products);
            CustomLogger::logInfo("Fetched all products");
            return $products;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching products: {$e->getMessage()}");
        }
    }

    private function mapGallery(array $products): array
    {
        $mappedProducts = [];
        foreach ($products as $product) {
            if (!isset($mappedProducts[$product['id']])) {
                $mappedProducts[$product['id']] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'brand' => $product['brand'],
                    'inStock' => $product['inStock'],
                    'category' => $product['category'],
                    'gallery' => [],
                ];
            }

            $mappedProducts[$product['id']]['gallery'][] = $product['gallery'];
        }
        return array_values($mappedProducts);
    }
}
