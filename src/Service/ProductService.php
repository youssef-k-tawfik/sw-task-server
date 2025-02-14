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

    /**
     * Fetches a list of products from the repository, optionally filtered by category and product ID.
     *
     * @param string|null $category Optional category filter.
     * @param string|null $productId Optional product ID filter.
     * @return array List of products.
     * @throws \Exception If no products are found or an error occurs during fetching.
     */
    public function getAllProducts(
        ?string $category = null,
        ?string $productId = null
    ): array {
        try {
            $products = $this->productRepository
                ->getAllProducts($category, $productId);

            if (!$products) {
                throw new \Exception("Products not found");
            }

            $products = $this->mapGallery($products);

            // CustomLogger::debug($products);
            if (count($products) === 1) {
                CustomLogger::logInfo("Fetched '{$products[0]['name']}' product data");
            } else {
                CustomLogger::logInfo("Fetched '{$category}' category products");
            }

            return $products;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching products: {$e->getMessage()}");
        }
    }

    /**
     * Maps the gallery URLs to the products.
     * 
     * @param array $products List of products.
     * @return array List of products with gallery URLs.
     * @throws \Exception If an error occurs during mapping.
     */
    private function mapGallery(array $products): array
    {
        try {
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
        } catch (\Exception $e) {
            throw new \Exception("Error mapping gallery: {$e->getMessage()}");
        }
    }
}
