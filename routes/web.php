<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardViewController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\NewsController;

Route::get('/', [DashboardViewController::class, 'index']);

Route::get('/country/{id}', [DashboardViewController::class, 'country']);

Route::get('/export/pdf', [ExportController::class, 'pdf']);

Route::get('/analytics', function () {
    return view('analytics');
    });


Route::get('/ports', [PortController::class, 'index'])->name('ports');

Route::get('/news', [NewsController::class, 'index'])->name('news');