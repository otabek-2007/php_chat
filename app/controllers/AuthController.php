<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\AuthService;

class AuthController
{
    protected $authService;

    public function __construct($pdo)
    {
        // AuthService ni in'ektsiya qilamiz
        $this->authService = new AuthService($pdo);
    }

    // Foydalanuvchi ro'yxatdan o'tishi
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Formdan ma'lumotlarni olish
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Ro'yxatdan o'tishni tekshirish
            $result = $this->authService->register($username, $email, $password, $confirmPassword);

            if ($result === true) {
                // Ro'yxatdan o'tish muvaffaqiyatli bo'lsa
                header('Location: /home');
                exit();
            } else {
                // Xato bo'lsa
                echo $result;
            }
        } else {
            // Ro'yxatdan o'tish sahifasini ko'rsatish
            include 'views/auth/register.php';
        }
    }

    // Foydalanuvchi tizimga kirishi
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Formdan ma'lumotlarni olish
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Loginni tekshirish
            $result = $this->authService->login($username, $password);

            if ($result === true) {
                // Tizimga kirish muvaffaqiyatli bo'lsa
                header('Location: /home');
                exit();
            } else {
                // Xato bo'lsa
                echo $result;
            }
        } else {
            // Login sahifasini ko'rsatish
            include 'views/auth/login.php';
        }
    }

    // Foydalanuvchi tizimdan chiqishi
    public function logout()
    {
        // Sessiyani tozalash
        session_start();
        session_unset();
        session_destroy();

        // Tizimdan chiqqanidan so'ng login sahifasiga yo'naltirish
        header('Location: /login');
        exit();
    }
}
