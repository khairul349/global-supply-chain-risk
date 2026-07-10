@extends('layouts.app')

@section('content')

<h2 class="mb-4">

🌍 Global Supply Chain Risk Dashboard

</h2>

<div class="mb-3">

    <a href="/export/pdf" class="btn btn-danger">

        📄 Export PDF

    </a>

</div>

@include('partials.filter')

@include('partials.stats')

@include('partials.chart')

@include('partials.top-chart')

@include('partials.map')

@include('partials.risk-table')

@endsection