const startDateContainer = document.querySelector('#start-date-container')
const startDateInput = document.querySelector('#start-date')
const endDateContainer = document.querySelector('#end-date-container')
const timesContainer = document.querySelector('#times-container')
const startDateLabel = document.querySelector('label[for="start-date"]')
const endDateInput = document.querySelector('#end-date')
const timesInputs = document.querySelectorAll('#times-container input')
const typePeriodRadioBtn = document.querySelector('#type-period')
const typeProgrammedRadioBtn = document.querySelector('#type-programmed')

typePeriodRadioBtn.addEventListener('change', () => {
    startDateLabel.innerHTML = 'Data inizio <span class="mandatory">*</span>'
    startDateInput.setAttribute("required", "")
    startDateContainer.classList.remove("d-none")
    endDateContainer.classList.remove("d-none")
    endDateInput.setAttribute("required", "")
    timesContainer.classList.add("d-none")
    timesInputs.forEach(i => { i.removeAttribute("required") })
})

typeProgrammedRadioBtn.addEventListener('change', () => {
    startDateLabel.innerHTML = 'Data <span class="mandatory">*</span>'
    startDateInput.setAttribute("required", "")
    startDateContainer.classList.remove("d-none")
    endDateContainer.classList.add("d-none")
    endDateInput.removeAttribute("required")
    timesContainer.classList.remove("d-none")
    timesInputs.forEach(i => { i.setAttribute("required", "") })
})
