<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Order\Order;
use App\Entity\Order\OrderProduct;
use App\Entity\Product;
use App\Entity\Attribute\Attribute;

use App\Service\ProductService;
use App\Utils\CustomLogger;

class OrderRepository
{
    private EntityManagerInterface $entityManager;
    private ProductService $productService;
    private PriceRepository $priceRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductService $productService,
        PriceRepository $priceRepository
    ) {
        $this->entityManager = $entityManager;
        $this->productService = $productService;
        $this->priceRepository = $priceRepository;
    }

    /**
     * Creates a new order by processing the order items, securely calculating the total cost.
     *
     * @param array $orderItems Input from GraphQL with productId, quantity, and selectedAttributes.
     * @return Order
     * @throws \Exception if a product or price is not found.
     */
    public function createOrder(array $orderItems): Order
    {
        try {
            CustomLogger::logInfo("Creating a new order.");
            $order = new Order();

            // Set the order number to the current date and a unique identifier
            $uniqueOrderNumber = date('Ymd') . '_' . uniqid();
            $order->setOrderNumber($uniqueOrderNumber);
            CustomLogger::logInfo("Order number generated: " . $uniqueOrderNumber);

            // Initialize the total cost
            $totalCost = 0;

            // Process each order item
            foreach ($orderItems as $itemData) {
                CustomLogger::debug(__FILE__, __LINE__,"Processing order item: " . json_encode($itemData));
                CustomLogger::logInfo("processing id: " . $itemData['productId']);

                // Fetching the product
                $product = $this->entityManager
                    ->getRepository(Product::class)
                    ->find($itemData['productId']);

                if (!$product) {
                    throw new \Exception("Product not found: " . $itemData['productId']);
                }

                CustomLogger::logInfo("Product found: " . $product->getName());

                // Fetching the price for the product
                //~ using my price repository
                $priceResult = $this->priceRepository
                    ->fetchAllPrices($itemData['productId']);

                //~ using doctrine
                //! doctrine hydration error "PHP Warning:  Undefined array key "prices" in 
                //! <PATH>\vendor\doctrine\orm\src\Internal\Hydration\ObjectHydrator.php on line 96"
                // $priceResult = $this->entityManager
                //     ->getRepository(Price::class)
                //     ->findBy(['product' => $itemData['productId']]);

                CustomLogger::logInfo("Price result: " . json_encode($priceResult));

                if (empty($priceResult)) {
                    throw new \Exception("Price not found for product: " . $itemData['productId']);
                }
                CustomLogger::debug(__FILE__, __LINE__,"Price result: " . json_encode($priceResult));

                $priceAmount = (float)$priceResult[0]['amount'];
                CustomLogger::logInfo("Price found: " . $priceAmount);

                // Calculate the cost for this order item and add it to the total cost
                $quantity = (int)$itemData['quantity'];
                $itemCost = $priceAmount * $quantity;
                $totalCost += $itemCost;
                CustomLogger::debug(__FILE__, __LINE__,"total cost: " . $totalCost);

                // Creating a new OrderProduct entity and setting the associations
                $orderProduct = new OrderProduct();
                $orderProduct->setOrder($order);
                $orderProduct->setProduct($product);
                $orderProduct->setQuantity($quantity);
                CustomLogger::debug(__FILE__, __LINE__,"Order product created");

                // Fetching products attributes if any
                if (!empty($itemData['selectedAttributes'])) {
                    // fetch selected attributes
                    $selectedAttributes = $itemData['selectedAttributes'];
                    CustomLogger::logInfo("Selected attributes: " . json_encode($selectedAttributes));

                    foreach ($selectedAttributes as $selectedAttribute) {
                        $attribute = $this->entityManager
                            ->getRepository(Attribute::class)
                            ->findOneBy([
                                'attributeSet' => $selectedAttribute['id'],
                                'value' => $selectedAttribute['value']
                            ]);

                        if (!$attribute) {
                            throw new \Exception("Attribute not found: " . $selectedAttribute['value']);
                        }
                        CustomLogger::debug(__FILE__, __LINE__,"Attribute found: " . $attribute->getValue());

                        $orderProduct->addSelectedAttribute($attribute);
                        CustomLogger::debug(__FILE__, __LINE__,"Attribute added to order product");
                    }
                    CustomLogger::logInfo("Attributes added!");
                }

                $this->entityManager->persist($orderProduct);
                CustomLogger::logInfo("Order product saved!");
            }

            $order->setTotalCost($totalCost);
            CustomLogger::logInfo("Total cost set: " . $totalCost);

            $this->entityManager->persist($order);
            $this->entityManager->flush();
            CustomLogger::logInfo("Order successfully saved!");

            return $order;
        } catch (\Exception $e) {
            CustomLogger::logInfo("Error placing order: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetches the dates of the given orders.
     *
     * @param array $orders
     * @return array
     */
    public function getDates(array $orders): array
    {
        CustomLogger::logInfo("Fetching dates for orders: " . json_encode($orders));
        try {
            $dates = [];
            foreach ($orders as $orderNumber) {
                $order = $this->entityManager
                    ->getRepository(Order::class)
                    ->findOneBy(['orderNumber' => $orderNumber]);

                if ($order) {
                    $placedAt = $order->getPlacedAt()->format('d M Y');
                    $dates[] = $placedAt;
                } else {
                    CustomLogger::logInfo("Order not found: " . $orderNumber);
                }
            }
            CustomLogger::logInfo("Dates fetched successfully!");
            return $dates;
        } catch (\Exception $e) {
            CustomLogger::logInfo("Error fetching dates: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieves an Order along with its associated OrderProducts, Products, and SelectedAttributes.
     *
     * @param string $orderNumber
     * @return Order
     * @throws \Exception If the order with the given order number is not found.
     */
    // public function getOrder(string $orderNumber): Order
    // {
    //     $query = $this->entityManager->createQuery(
    //         'SELECT o, op, p, a
    //          FROM App\Entity\Order\Order o
    //          JOIN o.orderProducts op
    //          JOIN op.product p
    //          LEFT JOIN op.selectedAttributes a
    //          WHERE o.orderNumber = :orderNumber'
    //     )->setParameter('orderNumber', $orderNumber);

    //     /** @var Order|null $order */
    //     $order = $query->getOneOrNullResult();

    //     if (!$order) {
    //         throw new \Exception("Order not found: " . $orderNumber);
    //     }

    //     return $order;
    // }
}
