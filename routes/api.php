<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RiskScoreController;
use App\Http\Controllers\DashboardController;

Route::get('/countries', [CountryController::class, 'index']);

Route::get('/countries/{id}', [CountryController::class, 'show']);

Route::get('/risk-scores', [RiskScoreController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);