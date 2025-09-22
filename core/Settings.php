<?php
class Settings {
    private static $instance = null;
    public $vatRate;
    public $shippingCost;

    private function __construct() {
        $this->vatRate = 0.15;
        $this->shippingCost = 50;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Settings();
        }
        return self::$instance;
    }
}
