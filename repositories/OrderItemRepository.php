<?php
require_once __DIR__ . '/../config/database.php';

class OrderItemRepository {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function create($orderId, $item) {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_name, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $orderId,
            $item['product_name'],
            $item['quantity'],
            $item['price']
        ]);
    }
}
