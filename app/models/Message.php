<?php

require_once __DIR__ . '/../../config/db_params.php';

class Message
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/db_params.php';

        try {
            $this->pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Xatolik: " . $e->getMessage());
        }
    }

    public function saveMessage($fromUserId, $toUserId, $messageText)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO messages (from_user_id, to_user_id, message) VALUES (:from_user_id, :to_user_id, :message)");
            $stmt->execute([
                'from_user_id' => $fromUserId,
                'to_user_id' => $toUserId,
                'message' => $messageText,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Xabar saqlashda xato: " . $e->getMessage());
        }
    }
}
