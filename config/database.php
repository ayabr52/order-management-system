<?php
class Database {
    private static $instance = null;
    public static function connect() {
        if (self::$instance === null) {
            $host = 'localhost';
            $dbname = 'order_db';
            $username = 'root';
            $password = '';
            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
