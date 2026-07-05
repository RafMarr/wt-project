const selectType = document.getElementById("type-select");
const divLuogo = document.getElementById("div-place-select");
const selectLuogo = document.getElementById("place-select");
const divPianoBlocco = document.getElementById("div-piano-blocco");
const selectPiano = document.getElementById("piano-select");
const selectBlocco = document.getElementById("blocco-select");
const labelLuogo = document.getElementById("place-label");

let places = [];

function updateSelectType() {
    selectLuogo.innerHTML = '<option value="">Scegli...</option>';
    places.forEach(place => {
        if ((selectPiano.value === "" || String(place.FloorID) === String(selectPiano.value))
            && (selectBlocco.value === "" || place.BlockID === selectBlocco.value))
        {
            const option = document.createElement("option");

            option.value = place.PlaceID;
            option.innerHTML = place.Name;
            selectLuogo.appendChild(option);
        }
    });
}

selectType.addEventListener("change", async () => {
    const valore = selectType.value;

    places = [];
    selectPiano.value = "";
    selectBlocco.value = "";
    updateSelectType();

    if (valore === "") {
        divLuogo.classList.add("d-none");
        selectLuogo.required = false;
        divPianoBlocco.classList.add("d-none");
        return;
    }

    labelLuogo.innerHTML = valore.charAt(0).toUpperCase() + valore.slice(1).toLowerCase();

    const type = valore;
    const url = "api/api-get-places.php";
    const formData = new FormData();
    formData.append('type', type);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        places = await response.json();
        divLuogo.classList.remove("d-none");
        selectLuogo.required = true;
        divPianoBlocco.classList.remove("d-none");

        updateSelectType();
    } catch (error) {
        console.log(error.message);
    }

    });

selectPiano.addEventListener("change", updateSelectType);
selectBlocco.addEventListener("change", updateSelectType);