<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function getAllProducts(): array
    {
        return $this->productRepository->fetchAllProducts();
    }

    public function getProductsByCategory(string $category): array
    {
        return $this->productRepository->fetchByCategory($category);
    }
}