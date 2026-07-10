<div class="card mt-4 shadow-sm">

    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">
            🌍 Top 10 Negara dengan Risk Score Tertinggi
        </h5>
    </div>

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">
                <input
                    type="text"
                    id="searchCountry"
                    class="form-control"
                    placeholder="Cari negara...">
            </div>

            <div class="col-md-3">
                <select id="regionFilter" class="form-select">
                    <option value="">Semua Region</option>
                    <option>Africa</option>
                    <option>Americas</option>
                    <option>Asia</option>
                    <option>Europe</option>
                    <option>Oceania</option>
                </select>
            </div>

            <div class="col-md-3">
                <select id="riskFilter" class="form-select">
                    <option value="">Semua Risk</option>
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                </select>
            </div>

            <div class="col-md-2">
                <button id="resetFilter" class="btn btn-secondary w-100">
                    Reset
                </button>
            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th width="60">No</th>

                        <th>Negara</th>

                        <th>Region</th>

                        <th>Total Score</th>

                        <th>Risk Level</th>

                    </tr>

                </thead>

                <tbody id="riskTable">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

let riskData = [];

fetch('/api/risk-scores')
.then(response => response.json())
.then(data => {

    riskData = data;

    renderTable(riskData);

});

function renderTable(data){

    let html = '';

    let no = 1;

    data.slice(0,10).forEach(item=>{

        let badge = 'success';

        if(item.risk_level == 'High'){
            badge = 'danger';
        }
        else if(item.risk_level == 'Medium'){
            badge = 'warning';
        }

        html += `
        <tr>

            <td>${no++}</td>

            <td>
                <a href="/country/${item.country.id}" class="fw-bold text-decoration-none">
                    ${item.country.name}
                </a>
            </td>

            <td>${item.country.region}</td>

            <td>${item.total_score}</td>

            <td>
                <span class="badge bg-${badge}">
                    ${item.risk_level}
                </span>
            </td>

        </tr>
        `;

    });

    document.getElementById('riskTable').innerHTML = html;

}

function applyFilter(){

    const keyword = document.getElementById('searchCountry').value.toLowerCase();

    const region = document.getElementById('regionFilter').value;

    const risk = document.getElementById('riskFilter').value;

    const filtered = riskData.filter(item=>{

        const cocokNama =
            item.country.name.toLowerCase().includes(keyword);

        const cocokRegion =
            region === '' ||
            item.country.region === region;

        const cocokRisk =
            risk === '' ||
            item.risk_level === risk;

        return cocokNama && cocokRegion && cocokRisk;

    });

    renderTable(filtered);

}

document.getElementById('searchCountry')
.addEventListener('keyup', applyFilter);

document.getElementById('regionFilter')
.addEventListener('change', applyFilter);

document.getElementById('riskFilter')
.addEventListener('change', applyFilter);

document.getElementById('resetFilter')
.addEventListener('click', function(){

    document.getElementById('searchCountry').value='';

    document.getElementById('regionFilter').value='';

    document.getElementById('riskFilter').value='';

    renderTable(riskData);

});

</script>