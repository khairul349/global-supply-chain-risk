<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;

class DashboardViewController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function country($id)
    {
        $country = Country::findOrFail($id);

        $risk = RiskScore::where('country_id', $id)->first();

        return view('country', compact('country', 'risk'));
    }
}