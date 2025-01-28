<?php

return [
    'home' => 'home/index', // Bosh sahifa
    'login' => 'auth/login', // Login sahifasi
    'register' => 'auth/register', // Ro'yxatdan o'tish sahifasi
    'logout' => 'auth/logout', // Chiqish
    'search-users' => 'auth/search', // Foydalanuvchi qidiruvi
    'send-message/([0-9]+)/([0-9]+)/(.+)' => 'message/sendMessage/$1/$2/$3',
];
