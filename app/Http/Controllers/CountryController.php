<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        return Country::orderBy('name')->get();
    }

    public function show($id)
    {
        return Country::with([
            'economicIndicators',
            'weatherSnapshots',
            'exchangeRates',
            'riskScores',
            'ports',
        ])->findOrFail($id);
    }
}