<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Global Supply Chain Risk Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-light">

<div class="container py-4">

    <h2 class="mb-4">
        🌍 Global Supply Chain Risk Dashboard
    </h2>

    <div class="row g-3">

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Total Negara</h5>

                    <h2 id="totalCountries">-</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>High Risk</h5>

                    <h2 id="highRisk">-</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Medium Risk</h5>

                    <h2 id="mediumRisk">-</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Low Risk</h5>

                    <h2 id="lowRisk">-</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4 shadow-sm">

        <div class="card-header">

            Distribusi Risk Level

        </div>

        <div class="card-body">

            <canvas id="riskChart"></canvas>

        </div>

    </div>

</div>

<script>

fetch('/api/dashboard')

.then(response => response.json())

.then(data => {

    document.getElementById('totalCountries').innerText = data.total_countries;

    document.getElementById('highRisk').innerText = data.high_risk;

    document.getElementById('mediumRisk').innerText = data.medium_risk;

    document.getElementById('lowRisk').innerText = data.low_risk;

    const ctx = document.getElementById('riskChart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [

                'High Risk',

                'Medium Risk',

                'Low Risk'

            ],

            datasets: [{

                label: 'Jumlah Negara',

                data: [

                    data.high_risk,

                    data.medium_risk,

                    data.low_risk

                ],

                backgroundColor: [

                    '#dc3545',

                    '#ffc107',

                    '#198754'

                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        }

    });

});

</script>

</body>

</html>