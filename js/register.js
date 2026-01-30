function checkFormValidity(form) {
    const inputs = form.querySelectorAll('input');
    return Array.from(inputs).every(input => !input.classList.contains('is-invalid'));
}

const form = document.querySelector('.needs-validation');
const emailInput = document.getElementById("email-utente");
const emailError = document.getElementById("errore-email");
const passwordInput = document.getElementById("password-utente");
const passwordError = document.getElementById("errore-password");
const confirmInput = document.getElementById("conferma-password");
const confirmError = document.getElementById("errore-conferma-password");
const idNumberInput = document.getElementById("matricola");
const idNumberError = document.getElementById("errore-matricola");

emailInput.addEventListener('blur', async () => {
    const email = emailInput.value;
    const url = 'api/api-check-email.php';
    const formData = new FormData();
    formData.append('email', email);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        if (json["exists"]){
            emailInput.classList.add("is-invalid");
            emailError.innerHTML = "Questa Email è già in uso!";
        }
        else {
            emailInput.classList.remove("is-invalid");
            emailError.innerHTML = "";
        }

    } catch (error) {
        console.log(error.message);
    }
});

idNumberInput.addEventListener('blur', async () => {
    const idNumber = idNumberInput.value;
    const url = "api/api-check-idNumber.php";
    const formData = new FormData();
    formData.append('idNumber', idNumber);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        if (json["exists"]){
            idNumberInput.classList.add("is-invalid");
            idNumberError.innerHTML = "Questa matricola è già in uso!";
            
        }
        else {
            idNumberInput.classList.remove("is-invalid");
            idNumberError.innerHTML = "";
        }

    } catch (error) {
        console.log(error.message);
    }
});

function checkConfirmPassword() {
    if (confirmInput.value !== passwordInput.value) {
        confirmInput.classList.add("is-invalid");
        confirmError.innerHTML = "Le password non coincidono.";
    }
    else {
        confirmInput.classList.remove("is-invalid");
        confirmError.innerHTML = "";
    }
}

passwordInput.addEventListener('input', () => {
    const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!regex.test(passwordInput.value)) {
        passwordInput.classList.add("is-invalid");
        passwordError.innerHTML = "La password deve essere di almeno 8 caratteri, inclusa 1 maiuscola, 1 minuscola e 1 numero!";
    }
    else {
        passwordInput.classList.remove("is-invalid");
        passwordError.innerHTML = "";
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