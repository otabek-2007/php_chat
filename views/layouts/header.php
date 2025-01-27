<?php
session_start(); // Sessiyani boshlash

// Foydalanuvchi tizimga kirganligini tekshirish
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Header</title>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <nav>
                <div class="logo-container">
                    <h1 class="logo">Chat App</h1>
                </div>
                <ul class="menu" id="menu-list">
                    <?php if ($isLoggedIn): ?>
                        <li><a href="/chat">Chat</a></li>
                        <li><a href="/logout">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                    <?php endif; ?>
                    <li class="theme-switcher">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </li>
                </ul>
                <!-- Hamburger icon for mobile -->
                <div class="hamburger" id="hamburger-icon">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <script src="/public/js/app.js"></script>
</body>

</html>