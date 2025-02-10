<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Service\CategoryService;
use App\Utils\CustomLogger;

class CategoryResolver
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategories(): array
    {
        CustomLogger::logInfo('Fetching all categories');
        return $this->categoryService->getAllCategories();
    }
}
