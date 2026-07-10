@extends('layouts.app')

@section('content')

<div class="container py-4">

    <a href="/" class="btn btn-secondary mb-4">
        ← Kembali ke Dashboard
    </a>

    <div class="card shadow">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 text-center">

                    <img src="{{ $country->flag_png }}"
                         class="img-fluid border rounded shadow-sm"
                         alt="{{ $country->name }}">

                </div>

                <div class="col-md-9">

                    <h2>{{ $country->name }}</h2>

                    <hr>

                    <div class="row">

                        <div class="col-md-6">

                            <p><strong>Capital :</strong> {{ $country->capital ?? '-' }}</p>

                            <p><strong>Region :</strong> {{ $country->region }}</p>

                            <p><strong>Sub Region :</strong> {{ $country->subregion }}</p>

                            <p><strong>Population :</strong> {{ number_format($country->population) }}</p>

                        </div>

                        <div class="col-md-6">

                            <p><strong>Currency :</strong> {{ $country->currency_name ?? '-' }}</p>

                            <p><strong>Currency Code :</strong> {{ $country->currency_code ?? '-' }}</p>

                            <p><strong>Latitude :</strong> {{ $country->latitude }}</p>

                            <p><strong>Longitude :</strong> {{ $country->longitude }}</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4 shadow">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">Risk Information</h5>

        </div>

        <div class="card-body">

            @if($risk)

            <table class="table table-bordered">

                <tr>

                    <th width="35%">Weather Score</th>

                    <td>{{ $risk->weather_score }}</td>

                </tr>

                <tr>

                    <th>Inflation Score</th>

                    <td>{{ $risk->inflation_score }}</td>

                </tr>

                <tr>

                    <th>Currency Score</th>

                    <td>{{ $risk->currency_score }}</td>

                </tr>

                <tr>

                    <th>News Score</th>

                    <td>{{ $risk->news_score }}</td>

                </tr>

                <tr class="table-primary">

                    <th>Total Score</th>

                    <td>

                        <strong>{{ $risk->total_score }}</strong>

                    </td>

                </tr>

                <tr>

                    <th>Risk Level</th>

                    <td>

                        @if($risk->risk_level == 'High')

                            <span class="badge bg-danger fs-6">High</span>

                        @elseif($risk->risk_level == 'Medium')

                            <span class="badge bg-warning text-dark fs-6">Medium</span>

                        @else

                            <span class="badge bg-success fs-6">Low</span>

                        @endif

                    </td>

                </tr>

            </table>

            @else

                <div class="alert alert-warning">

                    Data Risk Score belum tersedia.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection