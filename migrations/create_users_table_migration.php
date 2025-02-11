<?php

require_once __DIR__ . '/../components/Db.php';

class CreateUsersTableMigration
{
    public static function up()
    {
        try {
            $pdo = Db::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            $pdo->exec($sql);

            // `updated_at` ustunini avtomatik yangilanishi uchun trigger qo'shish
            $triggerSql = "CREATE OR REPLACE FUNCTION update_updated_at_column()
                RETURNS TRIGGER AS $$
                BEGIN
                    NEW.updated_at = CURRENT_TIMESTAMP;
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;

                CREATE TRIGGER update_users_updated_at
                BEFORE UPDATE ON users
                FOR EACH ROW
                EXECUTE FUNCTION update_updated_at_column();";

            $pdo->exec($triggerSql);

            echo "Users jadvali muvaffaqiyatli yaratildi.\n";
        } catch (PDOException $e) {
            echo "Users jadvalini yaratishda xato: " . $e->getMessage() . "\n";
        }
    }

    public static function down()
    {
        try {
            $pdo = Db::getConnection();

            // Triggerni o'chirish
            $pdo->exec("DROP TRIGGER IF EXISTS update_users_updated_at ON users");
            $pdo->exec("DROP FUNCTION IF EXISTS update_updated_at_column");

            // Jadvalni o'chirish
            $pdo->exec("DROP TABLE IF EXISTS users");

            echo "Users jadvali muvaffaqiyatli o'chirildi.\n";
        } catch (PDOException $e) {
            echo "Users jadvalini o'chirishda xato: " . $e->getMessage() . "\n";
        }
    }
}
