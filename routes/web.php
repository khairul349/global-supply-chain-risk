<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardViewController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ExportController;

Route::get('/', [DashboardViewController::class, 'index']);

Route::get('/country/{id}', [DashboardViewController::class, 'country']);

Route::get('/export/pdf', [ExportController::class, 'pdf']);