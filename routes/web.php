<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardViewController;

Route::get('/', [DashboardViewController::class, 'index']);