<?php
require_once __DIR__ . '/../services/OrderService.php';

class OrderFacade {
    public static function createOrder($customerName, $items) {
        $service = new OrderService();
        return $service->createOrder($customerName, $items);
    }
}
