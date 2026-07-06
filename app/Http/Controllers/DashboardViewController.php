<?php

namespace App\Http\Controllers;

class DashboardViewController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}