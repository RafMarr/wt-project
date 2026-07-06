const divReports = document.querySelectorAll("[data-report-id]");
const modalStateSelect = document.getElementById("state-select");
const modalApplyButton = document.getElementById("modal-apply-button");

let currentReportID = null;
let currentPState = null;

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

divReports.forEach(div => {
    const reportID = div.dataset.reportId;
    const deleteButton = div.querySelector("button.mode-danger");
    deleteButton.addEventListener("click", async (e) => {
        e.preventDefault();

        if (!confirm("Sei sicuro di voler eliminare questa segnalazione?")) {
            return;
        }

        const url = "api/api-delete-report.php";
        const formData = new FormData();
        formData.append('reportID', reportID);
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
                div.remove();
            }
        } catch (error) {
            console.log(error.message);
        }
    });

    const stateButton = div.querySelector("button.theme-bg-text");

    stateButton.addEventListener("click", () => {
        currentReportID = reportID;
        currentPState = div.querySelector("p.state-p");
    });
});