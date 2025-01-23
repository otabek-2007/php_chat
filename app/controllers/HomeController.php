<?php

namespace App\controllers;

class HomeController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Bosh sahifa'];
        $this->render('home/index', $data);
    }
}
