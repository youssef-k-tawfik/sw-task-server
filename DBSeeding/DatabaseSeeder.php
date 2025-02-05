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
CustomLogger::logInfo("Creating schema...");
$schemaTool = new SchemaTool($entityManager);
$classes = $entityManager->getMetadataFactory()->getAllMetadata();
$schemaTool->updateSchema($classes);
CustomLogger::logInfo("Schema created successfully.");

foreach ($data['categories'] as $categoryData) {
    CustomLogger::logInfo("Processing category: {$categoryData['name']}");

    // if category already exists, skip
    $categoryRepository = $entityManager
        ->getRepository(Category::class);
    $category = $categoryRepository
        ->findOneBy(['name' => $categoryData['name']]);
    if ($category) {
        continue;
    }

    $category = new Category();
    $category->setName($categoryData['name']);
    $entityManager->persist($category);
    $entityManager->flush($category);
    CustomLogger::logInfo("Category with name: '{$category->getName()}' created.");
}

foreach ($data['products'] as $productData) {
    CustomLogger::logInfo("Processing product: '{$productData['name']}'");
    $productRepository = $entityManager
        ->getRepository(Product::class);
    $product = $productRepository
        ->findOneBy(['id' => $productData['id']]);

    // If product does not exist, create a new one
    if (!$product) {
        $product = new Product();
        $product
            ->setId($productData['id'])
            ->setName($productData['name'])
            ->setDescription($productData['description'])
            ->setInStock($productData['inStock'])
            ->setBrand($productData['brand']);

        // Set category
        $categoryRepository = $entityManager
            ->getRepository(Category::class);
        $category = $categoryRepository
            ->findOneBy(['name' => $productData['category']]);
        $product->setCategory($category);

        $entityManager->persist($product);
        $entityManager->flush($product);
        CustomLogger::logInfo("Product with ID: '{$product->getId()}' created.");
    }

    //^ Set gallery
    foreach ($productData['gallery'] as $imageUrl) {
        CustomLogger::logInfo("Processing gallery with URL: '{$imageUrl}'");

        $gallery = new Gallery();
        $gallery->setURL($imageUrl);
        $product->addGallery($gallery);
        $gallery->setProduct($product);
        $entityManager->persist($gallery);
        $entityManager->flush($gallery);

        CustomLogger::logInfo("Gallery with URL: '{$gallery->getURL()}' created.");
    }

    //^ Set prices
    foreach ($productData['prices'] as $priceData) {
        CustomLogger::logInfo("Processing price with amount: '{$priceData['amount']}'");

        $price = new Price();
        $price->setAmount($priceData['amount']);

        $currencyRepository = $entityManager
            ->getRepository(Currency::class);
        $currency = $currencyRepository
            ->findOneBy(['label' => $priceData['currency']['label']]);

        if (!$currency) {
            CustomLogger::logInfo("Currency with label: '{$priceData['currency']['label']}' not found. \nCreating new currency.");

            $currency = new Currency();
            $currency->setLabel($priceData['currency']['label']);
            $currency->setSymbol($priceData['currency']['symbol']);
            $entityManager->persist($currency);
            $entityManager->flush($currency);

            CustomLogger::logInfo("Currency with label: {$currency->getLabel()} created.");
        }

        $price->setCurrency($currency);
        $price->setProduct($product);
        $product->addPrice($price);
        $entityManager->persist($price);
        $entityManager->flush($price);

        CustomLogger::logInfo("Price with amount: {$price->getAmount()} created.");
    }

    //^ Set attributes
    foreach ($productData['attributes'] as $attributeSetData) {
        CustomLogger::logInfo("Processing attribute set with name: '{$attributeSetData['name']}'");
        $attributeSetRepository = $entityManager
            ->getRepository(AttributeSet::class);
        $attributeSet = $attributeSetRepository
            ->findOneBy(['id' => $attributeSetData['id']]);

        // If attribute set does not exist, create a new one
        if (!$attributeSet) {
            CustomLogger::logInfo("Attribute set with name: '{$attributeSetData['name']}' not found. \nCreating new attribute set.");

            $attributeSet = new AttributeSet();
            $attributeSet->setId($attributeSetData['id']);
            $attributeSet->setName($attributeSetData['name']);
            $attributeSet->setType($attributeSetData['type']);
            $entityManager->persist($attributeSet);
            $entityManager->flush($attributeSet);

            CustomLogger::logInfo("Attribute set with name: '{$attributeSet->getName()}' created.");
        }

        foreach ($attributeSetData['items'] as $attributeData) {
            CustomLogger::logInfo("Processing attribute with display value: '{$attributeData['displayValue']}'");

            $attributeRepository = $entityManager
                ->getRepository(Attribute::class);
            $attribute = $attributeRepository
                ->findOneBy(['id' => $attributeData['id']]);

            // If attribute does not exist, create a new one
            if (!$attribute) {
                CustomLogger::logInfo("Attribute with display value: '{$attributeData['displayValue']}' not found. \nCreating new attribute.");

                $attribute = new Attribute();
                $attribute->setId($attributeData['id']);
                $attribute->setDisplayValue($attributeData['displayValue']);
                $attribute->setValue($attributeData['value']);
                $attribute->setAttributeSet($attributeSet);
                $entityManager->persist($attribute);
                $entityManager->flush($attribute);

                CustomLogger::logInfo("Attribute with display value: '{$attribute->getDisplayValue()}' created.");
            }

            $product->addAttribute($attribute);

            CustomLogger::logInfo("Attribute with display value: '{$attribute->getDisplayValue()}' added to product: '{$product->getId()}'.");
        }
    }

    $entityManager->persist($product);
    $entityManager->flush();
}


$entityManager->flush();

echo "Database seeding completed.\n";
