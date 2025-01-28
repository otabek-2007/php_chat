<?php

namespace App\Models;

use App\Services\AuthService;
use PDO;

class User
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Foydalanuvchi ro'yxatdan o'tishi
    public function create($username, $email, $password)
    {
        // Parolni hashlash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Foydalanuvchini saqlash
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        // Foydalanuvchi ID sini qaytarish
        return $this->pdo->lastInsertId();
    }


    public function search($query)
    {
        $sql = "SELECT * FROM users WHERE name LIKE :query";
        $stmt = $this->pdo->prepare($sql);

        // Bind the parameter to the query with wildcard for 'like' search
        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->execute();

        // Fetch all matching users
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Foydalanuvchi nomi bilan ma'lumotlarni olish
    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
