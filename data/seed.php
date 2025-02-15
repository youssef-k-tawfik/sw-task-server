<?php

declare(strict_types=1);

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Gallery;
use App\Entity\Price;
use App\Entity\AttributeSet;
use App\Entity\Attribute;
use Doctrine\ORM\Tools\SchemaTool;
use App\Config\Doctrine;
use App\Entity\Currency;
use App\Utils\CustomLogger;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

CustomLogger::logInfo("Starting database seeding process...");

$data = json_decode(file_get_contents(__DIR__ . '/data.json'), true)['data'];

$entityManager = (new Doctrine())->getEntityManager();

//^ Create schema
$schemaTool = new SchemaTool($entityManager);
$classes = $entityManager->getMetadataFactory()->getAllMetadata();
$schemaTool->updateSchema($classes);
CustomLogger::logInfo("Schema created successfully.");

foreach ($data['categories'] as $categoryData) {
    $categoryRepository = $entityManager
        ->getRepository(Category::class);

    // if category already exists, skip
    $category = $categoryRepository
        ->findOneBy(['name' => $categoryData['name']]);
    if ($category) {
        continue;
    }

    $category = new Category();
    $category->setName($categoryData['name']);

    $entityManager->persist($category);
    $entityManager->flush($category);

    CustomLogger::logInfo("Category: '{$category->getName()}' created.");
}

foreach ($data['products'] as $productData) {
    $product = new Product();
    $product
        ->setId($productData['id'])
        ->setName($productData['name'])
        ->setDescription($productData['description'])
        ->setInStock($productData['inStock'])
        ->setBrand($productData['brand']);

    //^ Set category
    $categoryRepository = $entityManager
        ->getRepository(Category::class);
    $category = $categoryRepository
        ->findOneBy(['name' => $productData['category']]);
    $product->setCategory($category);

    $entityManager->persist($product);
    $entityManager->flush($product);
    CustomLogger::logInfo("Product: '{$product->getName()}' created.");

    //^ Set gallery
    foreach ($productData['gallery'] as $imageUrl) {
        $gallery = new Gallery();
        $gallery->setURL($imageUrl);
        $product->addGallery($gallery);
        $gallery->setProduct($product);

        CustomLogger::logInfo("A gallery created and added to Product: '{$product->getName()}' with URL: '{$gallery->getURL()}'.");
    }

    //^ Set prices
    foreach ($productData['prices'] as $priceData) {
        $price = new Price();
        $price->setAmount($priceData['amount']);

        // If currency does not exist, create a new one
        $currencyRepository = $entityManager
            ->getRepository(Currency::class);
        $currency = $currencyRepository
            ->findOneBy(['label' => $priceData['currency']['label']]);
        if (!$currency) {
            $currency = new Currency();
            $currency
                ->setLabel($priceData['currency']['label'])
                ->setSymbol($priceData['currency']['symbol']);
            $entityManager->persist($currency);
            $entityManager->flush($currency);

            CustomLogger::logInfo("Currency: '{$currency->getLabel()}' created.");
        }

        $price->setCurrency($currency);
        $price->setProduct($product);
        $product->addPrice($price);

        CustomLogger::logInfo("A price created and added to Product: '{$product->getName()}' with amount: '{$price->getAmount()}'.");
    }

    //^ Set attributes
    foreach ($productData['attributes'] as $attributeSetData) {
        $attributeSetRepository = $entityManager
            ->getRepository(AttributeSet::class);
        $attributeSet = $attributeSetRepository
            ->findOneBy(['id' => $attributeSetData['id']]);

        // If attribute set does not exist, create a new one
        if (!$attributeSet) {
            $attributeSet = new AttributeSet();
            $attributeSet
                ->setId($attributeSetData['id'])
                ->setName($attributeSetData['name'])
                ->setType($attributeSetData['type']);
            $entityManager->persist($attributeSet);
            $entityManager->flush($attributeSet);

            CustomLogger::logInfo("Attribute set: '{$attributeSet->getName()}' created.");
        }

        foreach ($attributeSetData['items'] as $attributeData) {
            $attributeRepository = $entityManager
                ->getRepository(Attribute::class);
            $attribute = $attributeRepository
                ->findOneBy([
                    'id' => $attributeData['id'],
                    'attributeSet' => $attributeSet
                ]);

            // If attribute does not exist, create a new one
            if (!$attribute) {
                $attribute = new Attribute();
                $attribute
                    ->setId($attributeData['id'])
                    ->setDisplayValue($attributeData['displayValue'])
                    ->setValue($attributeData['value'])
                    ->setAttributeSet($attributeSet);

                CustomLogger::logInfo("Attribute: '{$attribute->getDisplayValue()}' created.");
            }

            $product->addAttribute($attribute);

            CustomLogger::logInfo("Attribute: '{$attribute->getDisplayValue()}' added to product: '{$product->getName()}'.");
        }
    }

    $entityManager->persist($product);
    $entityManager->flush();
}

$entityManager->flush();

echo "Database seeding completed.\n";
