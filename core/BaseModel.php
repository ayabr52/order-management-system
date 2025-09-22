<?php
require_once __DIR__ . '/../config/database.php';

class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::connect();
    }
}
