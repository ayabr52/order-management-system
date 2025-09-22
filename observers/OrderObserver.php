<?php
require_once __DIR__ . '/../core/BaseModel.php';

class OrderObserver extends BaseModel {
    public function logCreation($orderId) {
        $stmt = $this->db->prepare("INSERT INTO order_logs (order_id, message) VALUES (?, ?)");
        $message = "تم إنشاء الطلب رقم $orderId";
        $stmt->execute([$orderId, $message]);
    }
}
