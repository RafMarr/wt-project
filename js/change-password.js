function checkFormValidity(form) {
    const inputs = form.querySelectorAll('input');
    return Array.from(inputs).every(input => !input.classList.contains('is-invalid'));
}

const form = document.querySelector('.needs-validation');
const currPassInput = document.getElementById("password-corrente");
const currPassError = document.getElementById("errore-password-corrente");
const newPassInput = document.getElementById("password-nuova");
const newPassError = document.getElementById("errore-password-nuova");
const confirmInput = document.getElementById("conferma-password");
const confirmError = document.getElementById("errore-conferma-password");

currPassInput.addEventListener('blur', async () => {
    const currPass = currPassInput.value;
    const url = "api/api-check-password.php";
    const formData = new FormData();
    formData.append('currPass', currPass);
    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        if (json["match"]){
            currPassInput.classList.remove("is-invalid");
            currPassError.innerHTML = "";
        }
        else {
            currPassInput.classList.add("is-invalid");
            currPassError.innerHTML = "La password è errata.";
        }

    } catch (error) {
        console.log(error.message);
    }
});

function checkConfirmPassword() {
    if (confirmInput.value !== newPassInput.value) {
        confirmInput.classList.add("is-invalid");
        confirmError.innerHTML = "Le password non coincidono.";
    }
    else {
        confirmInput.classList.remove("is-invalid");
        confirmError.innerHTML = "";
    }
}

newPassInput.addEventListener('input', () => {
    const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!regex.test(newPassInput.value)) {
        newPassInput.classList.add("is-invalid");
        newPassError.innerHTML = "La password deve essere di almeno 8 caratteri, inclusa 1 maiuscola, 1 minuscola e 1 numero!";
    }
    else {
        newPassInput.classList.remove("is-invalid");
        newPassError.innerHTML = "";
    }

    if (confirmInput.value !== "") {
        checkConfirmPassword();
    }
});

confirmInput.addEventListener('input', checkConfirmPassword);

form.addEventListener('submit', event => {
    
        // If the form has any invalid fields or our custom checks failed
        if (!checkFormValidity(form)) {
            event.preventDefault();
            event.stopPropagation();
        }

    }, false);