const radioLuoghi = document.querySelectorAll('input[name="luogo-segnalazione"]');
const divAulee = document.getElementById("div-aulee");
const selectAula = document.getElementById("aula-select");
const divLabs = document.getElementById("div-labs");
const selectLab = document.getElementById("lab-select");
const divBagni = document.getElementById("div-bagni");
const selectBagni = document.getElementById("bagni-select");
const divPianoBlocco = document.getElementById("div-piano-blocco");
const inputPiano = document.getElementById("piano-corridoio");
const selectBlocco = document.getElementById("blocco-corridoio");
const divPianiParcheggi = document.getElementById("div-parcheggi");
const selectParcheggi = document.getElementById("piani-parcheggi");

radioLuoghi.forEach(radio => {
    radio.addEventListener("change", (e) => {
        const valore = e.target.value;

        divAulee.classList.add("d-none");
        selectAula.required = false;
        divLabs.classList.add("d-none");
        selectLab.required = false;
        divPianoBlocco.classList.add("d-none");
        inputPiano.required = false;
        selectBlocco.required = false;
        divPianiParcheggi.classList.add("d-none");
        selectParcheggi.required = false;
        divBagni.classList.add("d-none");
        selectBagni.required = false;

        if (valore === "AULA") {
            divAulee.classList.remove("d-none");
            selectAula.required = true;
        }
        else if (valore === "LAB.") {
            divLabs.classList.remove("d-none");
            selectLab.required = true;
        }
        else if (valore === "Bathroom") {
            divBagni.classList.remove("d-none");
            selectBagni.required = true;
        }
        else if (valore === "Corridor") {
            divPianoBlocco.classList.remove("d-none");
            inputPiano.required = true;
            selectBlocco.required = true;
        }
        else if (valore === "Bike-Parking") {
            divPianiParcheggi.classList.remove("d-none");
            selectParcheggi.required = true;
        }


    });
});