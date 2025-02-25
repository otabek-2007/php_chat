<?php

require_once __DIR__ . '/../config/db_params.php';

class CreateMessageTableMigration
{
    public static function up()
    {
        $config = require __DIR__ . '/../config/db_params.php';

        try {
            $pdo = new PDO(
                "pgsql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE IF NOT EXISTS messages (
                id SERIAL PRIMARY KEY,
                from_user_id INT NOT NULL,
                to_user_id INT NOT NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            $pdo->exec($sql);
            echo "Xabarlar jadvali muvaffaqiyatli yaratildi!\n";
        } catch (PDOException $e) {
            echo "Xabarlar jadvalini yaratishda xato: " . $e->getMessage() . "\n";
        }
    }

    public static function down()
    {
        $config = require __DIR__ . '/../config/db_params.php';

        try {
            $pdo = new PDO(
                "pgsql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DROP TABLE IF EXISTS messages";

            $pdo->exec($sql);
            echo "Xabarlar jadvali muvaffaqiyatli o'chirildi!\n";
        } catch (PDOException $e) {
            echo "Xabarlar jadvalini o'chirishda xato: " . $e->getMessage() . "\n";
        }
    }
}
