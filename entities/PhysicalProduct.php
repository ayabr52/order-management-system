<?php
require_once __DIR__ . '/ProductEntity.php';

class PhysicalProduct extends ProductEntity {
    public $shippingCost;

    public function __construct($name, $price, $quantity, $shippingCost) {
        parent::__construct($name, $price, $quantity);
        $this->shippingCost = $shippingCost;
    }

    public function calculateTotal() {
        return parent::calculateTotal() + $this->shippingCost;
    }
}
