<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        include 'views/chat/index.php';
    }
}
