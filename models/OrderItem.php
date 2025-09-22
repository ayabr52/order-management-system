<?php
require_once __DIR__ . '/../core/BaseModel.php';

class OrderItem extends BaseModel {
    public function getByOrderId($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['order_id'],
            $data['product_name'],
            $data['quantity'],
            $data['price']
        ]);
    }
}
