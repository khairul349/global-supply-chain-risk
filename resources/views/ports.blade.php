@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 mt-2">

        <div>

            <h1 class="h3 fw-bold mb-1" style="letter-spacing: -0.02em;">
                🚢 World Ports
            </h1>

            <p class="text-muted fw-medium mb-0">
                Global maritime logistics hub tracking database
            </p>

        </div>

        <span class="badge bg-primary fs-6" style="padding: 10px 16px !important; border-radius: 12px !important;">

            Total Tracked:
            <strong style="font-size: 15px; margin-left: 2px;">{{ number_format($ports->total()) }}</strong>

        </span>

    </div>

    <!-- Search Form -->
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search port name...">

                    </div>

                    <div class="col-md-4">

                        <select
                            name="country"
                            class="form-select">

                            <option value="">

                                All Countries

                            </option>

                            @foreach($countries as $country)

                                <option
                                    value="{{ $country->id }}"
                                    @selected(request('country')==$country->id)>

                                    {{ $country->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button class="btn btn-primary flex-grow-1 fw-bold" style="border-radius: 12px; padding: 10px 16px; background-color: #6366f1; border-color: #6366f1;">

                            🔍 Search

                        </button>

                        <a href="{{ route('ports') }}"
                           class="btn btn-outline-light fw-bold"
                           style="border-radius: 12px; padding: 10px 16px; border-color: var(--border-color);">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Map container inside card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>🗺️ Maritime Hubs Distribution</span>
            <span class="text-muted fw-normal" style="font-size: 13px;">Ports spatial map</span>
        </div>
        <div class="card-body p-0" style="border-radius: 0 0 20px 20px; overflow: hidden;">
            <div id="portMap" style="height:480px"></div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>

                    <tr style="border-bottom: 2px solid var(--border-color);">

                        <th width="80" style="padding-left: 24px;">No</th>

                        <th>Port Name</th>

                        <th>Country</th>

                        <th>Latitude</th>

                        <th>Longitude</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($ports as $port)

                    <tr>

                        <td style="padding-left: 24px;" class="text-muted fw-semibold">

                            {{ ($ports->currentPage() - 1) * $ports->perPage() + $loop->iteration }}

                        </td>

                        <td class="fw-bold" style="color: var(--text-main);">

                            {{ $port->name }}

                        </td>

                        <td>

                            {{ $port->country->name }}

                        </td>

                        <td class="text-muted" style="font-size: 13.5px;">

                            {{ $port->latitude }}

                        </td>

                        <td class="text-muted" style="font-size: 13.5px;">

                            {{ $port->longitude }}

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $ports->links() }}
    </div>

</div>

@endsection

@push('scripts')

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

const map=L.map('portMap').setView([20,0],2);

let activeTileLayer;
function getTileUrl() {
    return document.body.classList.contains('bg-dark')
        ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
}

activeTileLayer = L.tileLayer(getTileUrl(), {
    maxZoom: 18,
    attribution: '© OpenStreetMap © CartoDB'
}).addTo(map);

// Watch for theme toggles to swap tiles
document.getElementById('darkModeBtn').addEventListener('click', () => {
    setTimeout(() => {
        map.removeLayer(activeTileLayer);
        activeTileLayer = L.tileLayer(getTileUrl(), {
            maxZoom: 18,
            attribution: '© OpenStreetMap © CartoDB'
        }).addTo(map);
    }, 100);
});

fetch('/api/ports')

.then(r=>r.json())

.then(data=>{

data.forEach(port=>{

L.marker([

port.latitude,

port.longitude

])

.addTo(map)

.bindPopup(`
    <div style="font-family:'Plus Jakarta Sans',sans-serif; padding: 4px;">
        <h6 style="font-weight:700; margin-bottom: 4px; font-size:14px; color:var(--text-main);">${port.name}</h6>
        <span class="text-muted" style="font-size:12px;">Country: <strong>${port.country.name}</strong></span>
    </div>
`);

});

});

</script>

@endpush