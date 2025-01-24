<?php

require_once __DIR__ . '/../config/db_params.php';

class CreateChatTableMigration
{
    public static function up()
    {
        $config = require __DIR__ . '/../config/db_params.php';

        try {
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE IF NOT EXISTS chat (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            $pdo->exec($sql);
            echo "Chat jadvali muvaffaqiyatli yaratildi!\n";
        } catch (PDOException $e) {
            echo "Chat jadvalini yaratishda xato: " . $e->getMessage() . "\n";
        }
    }

    public static function down()
    {
        $config = require __DIR__ . '/../config/db_params.php';

        try {
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DROP TABLE IF EXISTS chat";

            $pdo->exec($sql);
            echo "Chat jadvali muvaffaqiyatli o'chirildi!\n";
        } catch (PDOException $e) {
            echo "Chat jadvalini o'chirishda xato: " . $e->getMessage() . "\n";
        }
    }
}
