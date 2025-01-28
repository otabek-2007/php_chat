<?php
session_start(); // Sessiyani boshlash

// Foydalanuvchi tizimga kirganligini tekshirish
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
?>

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
            <div class="hamburger" id="hamburger-icon">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </div>
</header>