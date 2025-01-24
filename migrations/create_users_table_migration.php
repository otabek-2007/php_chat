<?php

require_once __DIR__ . '/../components/Db.php';

class CreateUsersTableMigration
{
    public static function up()
    {
        try {
            $pdo = Db::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

            $pdo->exec($sql);
            echo "Users table created successfully.\n";
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage() . "\n";
        }
    }

    public static function down()
    {
        try {
            $pdo = Db::getConnection();

            $sql = "DROP TABLE IF EXISTS users";

            $pdo->exec($sql);
            echo "Users table dropped successfully.\n";
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage() . "\n";
        }
    }
}
