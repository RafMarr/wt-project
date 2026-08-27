const resetFiltersButton = document.getElementById('resetFiltersBtn');
const luogoFilter = document.getElementById('luogoFilter');
const statoFilter = document.getElementById('statoFilter');
const divContainer = document.getElementById('report-container');

let reports = [];

resetFiltersButton.addEventListener('click', () => {
    if (luogoFilter.value != "all") luogoFilter.value = "all";
    if (statoFilter.value != "all") statoFilter.value = "all";

    fetchReports();
});

function updateDivReports() {
    divContainer.innerHTML = "";
    reports.forEach(report => {
        divContainer.innerHTML += `<div class="col">
                                        <div class="border-mode-gray border-2 border-solid rounded mode-gray p-2">
                                            <h3 class="border-b-2 border-mode-gray rounded">${report.Type}</h3>
                                            <p><strong>Luogo</strong>: ${report.Name}</p>
                                            <p><strong>Stato</strong>: ${report.State}</p>
                                            <p><strong>Data Inserimento</strong>: ${report.CreationDate}</p>
                                            <p><strong>Descrizione</strong>: ${report.Description}</p>
                                        </div>
                                    </div>`;
    });
}

async function fetchReports() {
    const luogo = luogoFilter.value;
    const stato = statoFilter.value;
    reports = [];
    updateDivReports();

    const url = "api/api-get-reports.php";
    const formData = new FormData();
    formData.append('stato', stato);
    formData.append('luogo', luogo);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        reports = await response.json();

        updateDivReports();
    } catch (error) {
        console.log(error.message);
    }
}

luogoFilter.addEventListener('change', fetchReports);
statoFilter.addEventListener('change', fetchReports);