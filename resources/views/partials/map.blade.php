<div class="card mt-4 shadow-sm">

    <div class="card-header bg-success text-white">
        <h5 class="mb-0">🌍 Peta Negara Berdasarkan Risk Level</h5>
    </div>

    <div class="card-body">
        <div id="map" style="height:600px;"></div>
    </div>

</div>

<script>

const map = L.map('map');

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution:'© OpenStreetMap'
}).addTo(map);

// ==================== ICON ====================

const blueIcon = new L.Icon({
    iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
    shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    iconSize:[25,41],
    iconAnchor:[12,41],
    popupAnchor:[1,-34],
    shadowSize:[41,41]
});

const greenIcon = new L.Icon({
    iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
    shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    iconSize:[25,41],
    iconAnchor:[12,41],
    popupAnchor:[1,-34],
    shadowSize:[41,41]
});

const yellowIcon = new L.Icon({
    iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-gold.png',
    shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    iconSize:[25,41],
    iconAnchor:[12,41],
    popupAnchor:[1,-34],
    shadowSize:[41,41]
});

const redIcon = new L.Icon({
    iconUrl:'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
    shadowUrl:'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    iconSize:[25,41],
    iconAnchor:[12,41],
    popupAnchor:[1,-34],
    shadowSize:[41,41]
});

// ==================== AMBIL DATA ====================

Promise.all([

    fetch('/api/countries').then(res => res.json()),

    fetch('/api/risk-scores').then(res => res.json())

])

.then(([countries, risks]) => {

    let markers = [];

    countries.forEach(country => {

        if(country.latitude == null || country.longitude == null){
            return;
        }

        // icon default
        let icon = blueIcon;

        let riskText = "Belum Ada";
        let score = "-";

        // cari risk berdasarkan country_id
        let risk = risks.find(r => r.country_id == country.id);

        if(risk){

            riskText = risk.risk_level;
            score = risk.total_score;

            if(risk.risk_level == "High"){
                icon = redIcon;
            }
            else if(risk.risk_level == "Medium"){
                icon = yellowIcon;
            }
            else if(risk.risk_level == "Low"){
                icon = greenIcon;
            }

        }

        let marker = L.marker([
            parseFloat(country.latitude),
            parseFloat(country.longitude)
        ],{
            icon:icon
        })
        .addTo(map)
        .bindPopup(`
            <b>${country.name}</b><br>
            Capital : ${country.capital ?? '-'}<br>
            Region : ${country.region}<br>
            Population : ${Number(country.population).toLocaleString()}<br><hr>
            <b>Risk Level :</b> ${riskText}<br>
            <b>Total Score :</b> ${score}
        `);

        markers.push(marker);

    });

    if(markers.length){

        let group = L.featureGroup(markers);

        map.fitBounds(group.getBounds(),{
            padding:[30,30]
        });

    }

})
.catch(error => {

    console.log(error);

});

</script>