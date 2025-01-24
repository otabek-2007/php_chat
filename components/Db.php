<?php
class Db {
    public static function getConnection() {
        $host = '127.0.0.1';
        $dbname = 'php-chat';
        $user = 'root';
        $password = '';
        $port = '3307';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        try {
            $db = new PDO($dsn, $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
