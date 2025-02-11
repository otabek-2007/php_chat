<?php

return [
    'home' => 'home/index', 
    'login' => 'auth/login', 
    'register' => 'auth/register', 
    'logout' => 'auth/logout', 
    'search-users' => 'auth/search', 
    'send-message/([0-9]+)/([0-9]+)/(.+)' => 'message/sendMessage/$1/$2/$3',
];
