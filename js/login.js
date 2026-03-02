const form = document.querySelector("form");
const emailInput = document.getElementById('email-utente');
const passwordInput = document.getElementById('password-utente');
const errorMessage = document.getElementById('messaggio-errore');

function checkFormValidation(form) {
    const inputs = form.querySelectorAll('input');
    return Array.from(inputs).every(input => !input.classList.contains('is-invalid'));
}

async function validateForm() {

    // Valida login
    const email = emailInput.value;
    const password = passwordInput.value;
    const url = 'api/api-check-login.php';
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

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
            emailInput.classList.remove("is-invalid");
            passwordInput.classList.remove("is-invalid");

            errorMessage.innerHTML = "";
            errorMessage.classList.add("d-none");
        }
        else {
            emailInput.classList.add("is-invalid");
            passwordInput.classList.add("is-invalid");

            errorMessage.classList.remove("d-none");
            errorMessage.innerHTML = "Email o Password Errata!";
        }

    } catch (error) {
        console.log(error.message);
    }
}

form.addEventListener('submit', async event => {
    
    await validateForm();
    if (checkFormValidation(form)) {
        form.submit();
    }

}, false);

// Per essere sicuri che il prevent default venga effettuato, quindi non messo in una funzione asincrona
form.addEventListener('submit', event => {
    event.preventDefault();
    event.stopPropagation();

}, false);