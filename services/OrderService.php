<?php
require_once __DIR__ . '/../repositories/OrderRepository.php';
require_once __DIR__ . '/../repositories/OrderItemRepository.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../observers/OrderObserver.php';
require_once __DIR__ . '/../core/Settings.php';
require_once __DIR__ . '/../entities/DigitalProduct.php';
require_once __DIR__ . '/../entities/PhysicalProduct.php';

class OrderService {
    private $orderRepo;
    private $itemRepo;
    private $productModel;
    private $observer;
    private $settings;

    public function __construct() {
        $this->orderRepo = new OrderRepository();
        $this->itemRepo = new OrderItemRepository();
        $this->productModel = new Product(); // من models/
        $this->observer = new OrderObserver();
        $this->settings = Settings::getInstance(); // Singleton
    }

    public function createOrder($customerName, $items) {
        $total = 0;
        $orderItems = [];

        foreach ($items as $item) {
            $productData = $this->productModel->find($item['product_id']);

            if (!$productData) {
                throw new Exception("المنتج غير موجود: ID = " . $item['product_id']);
            }

            // إنشاء كائن المنتج حسب النوع
            if ($productData['type'] === 'digital') {
                $product = new DigitalProduct(
                    $productData['name'],
                    $productData['price'],
                    $item['quantity']
                );
            } else {
                $product = new PhysicalProduct(
                    $productData['name'],
                    $productData['price'],
                    $item['quantity'],
                    $this->settings->shippingCost
                );
            }

            // حساب السعر الإجمالي للمنتج
            $subtotal = $product->calculateTotal();
            $vat = $subtotal * $this->settings->vatRate;
            $total += $subtotal + $vat;

            // تجهيز بيانات العنصر
            $orderItems[] = [
                'product_name' => $productData['name'],
                'quantity' => $item['quantity'],
                'price' => $productData['price']
            ];
        }

        // إنشاء الطلب
        $orderId = $this->orderRepo->create([
            'customer_name' => $customerName,
            'status' => 'pending',
            'total_price' => $total
        ]);

        // حفظ عناصر الطلب
        foreach ($orderItems as $item) {
            $this->itemRepo->create($orderId, $item);
        }

        // تسجيل الحدث
        $this->observer->logCreation($orderId);

        return $orderId;
    }
}
