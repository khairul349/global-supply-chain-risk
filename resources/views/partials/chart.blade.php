<div class="card mt-4 shadow-sm">

    <div class="card-header">
        Distribusi Risk Level
    </div>

    <div class="card-body">

        <canvas id="riskChart"></canvas>

    </div>

</div>

<script>

let chart;

fetch('/api/dashboard')

.then(response => response.json())

.then(data => {

    document.getElementById('totalCountries').innerText = data.total_countries;

    document.getElementById('highRisk').innerText = data.high_risk;

    document.getElementById('mediumRisk').innerText = data.medium_risk;

    document.getElementById('lowRisk').innerText = data.low_risk;

    chart = new Chart(document.getElementById('riskChart'),{

        type:'bar',

        data:{

            labels:[

                'High Risk',

                'Medium Risk',

                'Low Risk'

            ],

            datasets:[{

                label:'Jumlah Negara',

                data:[

                    data.high_risk,

                    data.medium_risk,

                    data.low_risk

                ],

                backgroundColor:[

                    '#dc3545',

                    '#ffc107',

                    '#198754'

                ]

            }]

        },

        options:{

            responsive:true,

            plugins:{

                legend:{

                    display:false

                }

            },

            scales:{

                y:{

                    beginAtZero:true

                }

            }

        }

    });

});

</script>