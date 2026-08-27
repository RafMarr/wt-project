const modalStateSelect = document.getElementById("state-select");
const modalApplyButton = document.getElementById("modal-apply-button");
const modalDeleteButton = document.getElementById("modal-delete-button");

let currentReportID = null;
let currentDiv = null;
let currentPState = null;

const resetFiltersButton = document.getElementById('resetFiltersBtn');
const luogoFilter = document.getElementById('luogoFilter');
const statoFilter = document.getElementById('statoFilter');
const divContainer = document.getElementById('report-container');

let reports = [];

modalApplyButton.addEventListener("click", async (e) => {
    if (!currentReportID || !currentPState) return;
    const state = modalStateSelect.value;
    const url = "api/api-change-state-report.php";
    const formData = new FormData();
    formData.append('state', state);
    formData.append('reportID', currentReportID);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const json = await response.json();
        
        if (json["success"]) {
            currentPState.innerHTML = `<strong>Stato</strong>: ${state}`;
        }
    } catch (error) {
        console.log(error.message);
    }
});

modalDeleteButton.addEventListener("click", async (e) => {
    if (!currentReportID || !currentDiv) return;
    const url = "api/api-delete-report.php";
    const formData = new FormData();
    formData.append('reportID', currentReportID);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const json = await response.json();
        
        if (json["success"]) {
            currentDiv.remove();
        }
    } catch (error) {
        console.log(error.message);
    }
});

function addButtonEventListeners() {
    const divReports = document.querySelectorAll("[data-report-id]");
    divReports.forEach(div => {
        const reportID = div.dataset.reportId;
        const deleteButton = div.querySelector("button.mode-danger");

        deleteButton.addEventListener("click", async (e) => {
            currentReportID = reportID;
            currentDiv = div;
        });

        const stateButton = div.querySelector("button.theme-bg-text");

        stateButton.addEventListener("click", () => {
            currentReportID = reportID;
            currentPState = div.querySelector("p.state-p");
        });
    });
}

resetFiltersButton.addEventListener('click', () => {
    if (luogoFilter.value != "all") luogoFilter.value = "all";
    if (statoFilter.value != "all") statoFilter.value = "all";

    fetchReports();
});

function updateDivReports() {
    divContainer.innerHTML = "";
    reports.forEach(report => {
        divContainer.innerHTML += `<div class="col">
                                    <div data-report-id="${report.ReportID}" class="border-mode-gray border-2 border-solid rounded mode-gray p-2">
                                        <h3 class="border-b-2 border-mode-gray rounded">${report.Type}</h3>
                                        <p><strong>Luogo</strong>: ${report.Name}</p>
                                        <p class="state-p"><strong>Stato</strong>: ${report.State}</p>
                                        <p><strong>Data Inserimento</strong>: ${report.CreationDate}</p>
                                        <p><strong>Descrizione</strong>: ${report.Description}</p>
                                        <div class="row justify-content-center gap-2">
                                            <button class="col-8 col-md-5 btn theme-bg-text" data-bs-toggle="modal" data-bs-target="#cambia-stato-report">Cambia Stato</button>
                                            <button class="col-8 col-md-5 btn mode-danger" data-bs-toggle="modal" data-bs-target="#elimina-segnalazione">Elimina</button>
                                        </div>
                                    </div>
                                </div>`;
    });

    addButtonEventListeners();
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

addButtonEventListeners();