<?php

namespace App\controllers;

class Controller
{
    // Bu yerda umumiy funksiyalarni yozishingiz mumkin.
    public function render($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../views/{$view}.php";
    }
}
