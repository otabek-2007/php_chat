<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    protected $pdo;
    protected $userModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

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

        // Foydalanuvchini yaratish va ID olish
        $userId = $this->userModel->create($username, $email, $password);

        // Foydalanuvchi yaratildi, sessiyaga ID saqlash
        session_start(); // Sessiyani ishga tushirish
        $_SESSION['user_id'] = $userId; // Yaratilgan foydalanuvchining ID sini sessiyaga saqlash
        $_SESSION['is_logged_in'] = true; // Foydalanuvchi tizimga kirganligini belgilash

        return true; // Ro'yxatdan o'tish muvaffaqiyatli
    }


    public function searchUsers($query)
    {
        // Use the User model to search users
        return $this->userModel->search($query);
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
        session_start(); // Sessiyani boshlash
        $_SESSION['user'] = $user; // Foydalanuvchi ID sini sessiyaga saqlash
        $_SESSION['is_logged_in'] = true; // Tizimga kirganligini belgilash

        return true;
    }
}
