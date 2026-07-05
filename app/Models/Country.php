<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'official_name',
        'cca2',
        'cca3',
        'capital',
        'region',
        'subregion',
        'currency_code',
        'currency_name',
        'currency_symbol',
        'language',
        'population',
        'latitude',
        'longitude',
        'flag_png',
        'flag_svg',
    ];
}