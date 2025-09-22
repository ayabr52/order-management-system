<?php
require_once __DIR__ . '/../facades/OrderFacade.php';
require_once __DIR__ . '/../repositories/OrderRepository.php';
require_once __DIR__ . '/../models/Product.php';

echo "<h1> نظام إدارة الطلبات</h1>";

//  إنشاء طلب جديد
echo "<h2>إنشاء طلب جديد</h2>";

try {
    $orderId = OrderFacade::createOrder("آية", [
        ['product_id' => 1, 'quantity' => 2],
        ['product_id' => 2, 'quantity' => 1]
    ]);
    echo " تم إنشاء الطلب رقم: $orderId<br>";
} catch (Exception $e) {
    echo " خطأ أثناء إنشاء الطلب: " . $e->getMessage();
}

//  عرض جميع الطلبات
echo "<h2>عرض جميع الطلبات</h2>";

$orderRepo = new OrderRepository();
$orders = $orderRepo->all();

if ($orders) {
    echo "<ul>";
    foreach ($orders as $order) {
        echo "<li>طلب رقم {$order['id']} - العميل: {$order['customer_name']} - السعر: {$order['total_price']} - الحالة: {$order['status']}</li>";
    }
    echo "</ul>";
} else {
    echo "لا توجد طلبات حالياً.";
}

//  عرض جميع المنتجات
echo "<h2>عرض جميع المنتجات</h2>";

/** @var Product $productModel */
$productModel = new Product();
$products = $productModel->getAll();

if ($products) {
    echo "<ul>";
    foreach ($products as $product) {
        echo "<li>{$product['name']} - {$product['description']} - السعر: {$product['price']} - النوع: {$product['type']}</li>";
    }
    echo "</ul>";
} else {
    echo "لا توجد منتجات حالياً.";
}
