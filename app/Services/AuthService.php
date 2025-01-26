<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    protected $userModel;
    
    public function __construct($pdo)
    {
        // PDO ni User modeliga uzatish
        $this->userModel = new User($pdo);
    }

    // Foydalanuvchi ro'yxatdan o'tishi
    public function register($username, $email, $password, $confirmPassword)
    {
        // Parollarni tasdiqlash
        if ($password !== $confirmPassword) {
            return "Parollar mos kelmayapti!";
        }

        // Foydalanuvchi nomi mavjudligini tekshirish
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser) {
            return "Bunday foydalanuvchi nomi mavjud!";
        }

        // Foydalanuvchini yaratish
        $this->userModel->create($username, $email, $password);

        return true;
    }

    // Foydalanuvchi tizimga kirishi
    public function login($username, $password)
    {
        // Foydalanuvchi ma'lumotlarini olish
        $user = $this->userModel->findByUsername($username);
        if (!$user) {
            return "Bunday foydalanuvchi topilmadi!";
        }

        // Parolni tekshirish
        if (!password_verify($password, $user['password'])) {
            return "Parol xato!";
        }

        // Foydalanuvchini tizimga kiritish
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        return true;
    }
}
