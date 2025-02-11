<?php
class Db
{
    public static function getConnection()
    {
        $host = '192.168.97.3'; 
        $dbname = 'php_chat'; 
        $user = 'root';    
        $password = 'secret';       
        $port = '5432';      

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        try {
            $db = new PDO($dsn, $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
