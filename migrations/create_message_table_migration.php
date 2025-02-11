<?php

require_once __DIR__ . '/../components/Db.php';

class CreateMessageTableMigration
{
    public static function up()
    {
        try {
            // Db.php dan ulanishni oling
            $pdo = Db::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS messages (
                id SERIAL PRIMARY KEY,
                from_user_id INT NOT NULL,
                to_user_id INT NOT NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE
            )";

            $pdo->exec($sql);
            echo "Xabarlar jadvali muvaffaqiyatli yaratildi!\n";
        } catch (PDOException $e) {
            echo "Xabarlar jadvalini yaratishda xato: " . $e->getMessage() . "\n";
        }
    }

    public static function down()
    {
        try {
            // Db.php dan ulanishni oling
            $pdo = Db::getConnection();

            $sql = "DROP TABLE IF EXISTS messages";

            $pdo->exec($sql);
            echo "Xabarlar jadvali muvaffaqiyatli o'chirildi!\n";
        } catch (PDOException $e) {
            echo "Xabarlar jadvalini o'chirishda xato: " . $e->getMessage() . "\n";
        }
    }
}
