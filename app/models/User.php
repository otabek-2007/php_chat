<?php

namespace App\Models;

use App\Services\AuthService;

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

        return true;
    }

    // Foydalanuvchi nomi bilan ma'lumotlarni olish
    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
