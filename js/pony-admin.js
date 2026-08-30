const resetFiltersButton = document.getElementById('resetFiltersBtn')
const priceFilter = document.getElementById('priceFilter')
const dateInput = document.querySelector('#day')
const startTimeInput = document.querySelector('#start-time')
const endTimeInput = document.querySelector('#end-time')
const allInputs = Array.from(document.querySelectorAll('#search-params input'))
const SATURDAY = 6
const HIPPODROME_OPENING_TIME = '09:00'
const HIPPODROME_WEEKDAYS_CLOSING_TIME = '18:30'
const HIPPODROME_WEEKEND_CLOSING_TIME = '13:00'
const main = document.querySelector('main')
/* The following variable is used to refresh the available ponies information only when needed */
let lastInputValidityCheckResult = false
/* The following two variables are the references to the anonymous functions that are used as the
click event handlers for the #hide-pony-button and #make-pony-available-button respectively.
In this way, it is possible to remove the event listeners attached to the above-mentioned
buttons when the modals they belong to are closed.
More information on this topic can be found here:
https://dev.to/smotchkkiss/function-identity-in-javascript-or-how-to-remove-event-listeners-properly-1ll3 */
let lastHidePonyButtonEventListener = null
let lastMakePonyAvailableButtonEventListener = null

main.classList.add('position-relative')
/* Removing from main tag the bootstrap classes that add padding top and margin top */
main.classList.forEach(c => {
    if (c.match(/pt-\d/) !== null || c.match(/mt-\d/) !== null) {
        main.classList.remove(c)
    }
})

resetFiltersButton.addEventListener('click', () => {
    if (priceFilter.value != "all") {
        priceFilter.value = "all"
        /* this instruction triggers the "change" event on priceFilter, in order to
           update the page content after filter reset */
        priceFilter.dispatchEvent(new Event('change'))
    }
})

priceFilter.addEventListener('change', () => {
    const priceFilterParameter = priceFilter.value != 'all' ? priceFilter.value : null
    if (allInputs.every(input => isInputValid(input))) {
        fetchPonies(dateInput.value, startTimeInput.value, endTimeInput.value, priceFilterParameter)
    } else {
        fetchPonies(null, null, null, priceFilterParameter)
    }
})

function getHippodromeClosingTime(date) {
    if (date instanceof Temporal.PlainDate) {
        return date.dayOfWeek >= SATURDAY ? HIPPODROME_WEEKEND_CLOSING_TIME : HIPPODROME_WEEKDAYS_CLOSING_TIME
    } else {
        throw new TypeError('The parameter type must be Temporal.PlainDate')
    }
}

function setInputStyleBasedOnValidity(input) {
    if (isInputValid(input)) {
        input.classList.remove('is-invalid')
        input.classList.add('is-valid')
    } else {
        input.classList.remove('is-valid')
        input.classList.add('is-invalid')
    }
}

function setInvalidFeedbackContent(input) {
    const invalidFeedbackElement = document.getElementById(input.getAttribute('aria-describedby'))
    /* invalid feedback has to be emptied when the related input is valid, otherwise screen readers
    will read the invalid feedback content even when the input is valid */
    if (isInputValid(input)) {
        invalidFeedbackElement.innerHTML = ''
    } else {
        if (input.value.length > 0) {
            if (input.getAttribute('type') == 'date') {
                /* The case in which the user inserts the current date but the hippodrome is already closed is handled
                separately in order to show a customised error message */
                if (input.value == Temporal.Now.plainDateISO().toString() && input.getAttribute('min') == Temporal.Now.plainDateISO().add({ days: 1 }).toString()) {
                    invalidFeedbackElement.innerHTML = 'Per la giornata di oggi non è più possibile effettuare prenotazioni'
                } else {
                    invalidFeedbackElement.innerHTML = 'La data inserita è precedente alla data odierna'
                }
            } else { // input's type is "time"
                if (input.validity.rangeUnderflow) {
                    invalidFeedbackElement.innerHTML = 'L\'orario minimo che può essere inserito è ' + input.getAttribute('min')
                } else if (input.validity.rangeOverflow) {
                    invalidFeedbackElement.innerHTML = 'L\'orario massimo che può essere inserito è ' + input.getAttribute('max')
                }
            }
        } else {
            invalidFeedbackElement.innerHTML = ''
        }
    }
}

function hasCurrentDate(input) {
    if ((input.tagName.toLowerCase() == "input") && input.getAttribute('type') == 'date') {    
        return isInputValid(input) && (Temporal.PlainDate.compare(Temporal.PlainDate.from(input.value), Temporal.Now.plainDateISO()) == 0)
    } else {
        throw new TypeError('The parameter must be an input of type date')
    }
}

function setStartTimeInputMinValue() {
    if (hasCurrentDate(dateInput)) {
        const currentTimeString = Temporal.Now.plainTimeISO().toString().slice(0, 5)
        startTimeInput.setAttribute('min', currentTimeString >= HIPPODROME_OPENING_TIME && currentTimeString <= getHippodromeClosingTime(Temporal.PlainDate.from(dateInput.value)) ? currentTimeString : HIPPODROME_OPENING_TIME)
    } else {
        startTimeInput.setAttribute('min', HIPPODROME_OPENING_TIME)
    }
}

function setEndTimeInputMinValue() {
    if (isInputValid(startTimeInput)) {
        endTimeInput.setAttribute('min', startTimeInput.value)
    } else if (hasCurrentDate(dateInput)) {
        const currentTime = Temporal.Now.plainTimeISO()
        const currentTimeString = currentTime.toString().slice(0, 5)
        endTimeInput.setAttribute('min', currentTimeString >= HIPPODROME_OPENING_TIME && currentTimeString <= getHippodromeClosingTime(Temporal.PlainDate.from(dateInput.value)) ? currentTimeString : HIPPODROME_OPENING_TIME)
    } else {
        endTimeInput.setAttribute('min', HIPPODROME_OPENING_TIME)
    }
}

function isInputValid(input) {
    /* the length check is needed because checkValidity() returns true if the input value is an empty string */
    return input.value.length > 0 && input.checkValidity()
}

allInputs.forEach(input => {
    input.addEventListener('change', () => {
        setInputStyleBasedOnValidity(input)
        
        const priceFilterParameter = priceFilter.value != 'all' ? priceFilter.value : null

        if (allInputs.every(input => isInputValid(input))) {
            lastInputValidityCheckResult = true
            fetchPonies(dateInput.value, startTimeInput.value, endTimeInput.value, priceFilterParameter)
        } else {
            /* The default ponies info must be fetched only when needed.
               If the last input validity check was successful, it means that
               the ponies shown in the page are the ones that meet the search
               parameters inserted by the user. So, considering that now the
               input validity check is not successful, the default ponies info
               must be fetched.
               On the other hand, if the last input validity check was not
               successful, nothing has to be fetched because the page is
               already showing the correct pony information. */
            if (lastInputValidityCheckResult) {
                fetchPonies(null, null, null, priceFilterParameter)
                lastInputValidityCheckResult = false
            }
        }
    })
})

dateInput.addEventListener('change', () => {

    if (isInputValid(dateInput)) {
        const dateSet = Temporal.PlainDate.from(dateInput.value)
        if (dateSet.dayOfWeek < SATURDAY) {
            startTimeInput.setAttribute('max', HIPPODROME_WEEKDAYS_CLOSING_TIME)
            endTimeInput.setAttribute('max', HIPPODROME_WEEKDAYS_CLOSING_TIME)
        } else {
            startTimeInput.setAttribute('max', HIPPODROME_WEEKEND_CLOSING_TIME)
            endTimeInput.setAttribute('max', HIPPODROME_WEEKEND_CLOSING_TIME)
        }
    }

    setStartTimeInputMinValue()
    setEndTimeInputMinValue()

    setInputStyleBasedOnValidity(startTimeInput)
    setInputStyleBasedOnValidity(endTimeInput)

    setInvalidFeedbackContent(dateInput)
    setInvalidFeedbackContent(startTimeInput)
    setInvalidFeedbackContent(endTimeInput)
})

startTimeInput.addEventListener('change', () => {
    setEndTimeInputMinValue()
    setInputStyleBasedOnValidity(endTimeInput)

    setInvalidFeedbackContent(startTimeInput)
    setInvalidFeedbackContent(endTimeInput)
})

endTimeInput.addEventListener('change', () => {
    setInvalidFeedbackContent(endTimeInput)
})

function generatePoniesCards(ponies) {
    let cards = "";

    ponies.forEach(pony => {
        let specMarksRow = ""
        let descriptionRow = ""
        let lastButton = ''

        if (pony["SpecMarks"] != null) {
            const marginBottomSpecMarks = pony["Description"] != null ? 'mb-1' : 'mb-4'
            specMarksRow = `<p class="${marginBottomSpecMarks}"><span class="fw-bold">Segni particolari:</span> ${pony["SpecMarks"]}</p>`
        }

        if (pony["Description"] != null) {
            descriptionRow = `<p class="mb-4"><span class="fw-bold">Descrizione:</span> ${pony["Description"]}</p>`
        }

        if (pony["IsAvailable"]) {
            lastButton = `<button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#hide-pony-modal">Nascondi</button>`
        } else {
            lastButton = `<button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#make-pony-available-modal">Mostra</button>`
        }

        const marginBottomHourlyFee = (pony["SpecMarks"] == null && pony["Description"] == null) ? 'mb-4' : 'mb-1'

        cards += `
        <div class="col">
            <article id="pony-${pony["PonyID"]}" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <!-- "alt" attribute is left empty as described in: https://html.spec.whatwg.org/dev/images.html#ancillary-images -->
                    <img src="${pony["Image"]}" class="img-fluid w-75 rounded-2" alt="">
                    <h3 class="p-0 m-0 mt-3 mb-2 fs-4">${pony["Name"]}</h3>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> ${pony["Breed"]}</p>
                    <p class="${marginBottomHourlyFee}"><span class="fw-bold">Costo:</span> ${pony["HourlyFee"]} €/ora</p>
                    ${specMarksRow}
                    ${descriptionRow}
                </div>
                <div class="d-flex justify-content-center gap-4 mt-md-auto">
                    <a href="pony.php?action=edit-pony&pony-id=${pony["PonyID"]}" class="btn border-0 theme-bg-text">Modifica</a>
                    ${lastButton}
                </div>
            </article>
        </div>
        `
    });

    return cards
}

document.querySelector("#hide-pony-modal").addEventListener('hidden.bs.modal', () => {
    document.querySelector("#hide-pony-modal .modal-body").innerHTML = ""
    document.querySelector("#hide-pony-button").removeEventListener('click', lastHidePonyButtonEventListener)
})

async function setHidePonyModalContent(ponyArticleID) {
    const ponyID = ponyArticleID.replace("pony-", "")
    const ponyName = document.querySelector(`#${ponyArticleID} h3`).innerHTML
    const modalBody = document.querySelector("#hide-pony-modal .modal-body")
    const hidePonyButton = document.querySelector("#hide-pony-button")
    modalBody.innerHTML = `<p>Sei sicuro di voler nascondere agli utenti il pony <span class="fw-bold">${ponyName}</span>?</p>
    <p>Il pony non sarà più visibile dagli studenti e dunque non sarà a disposizione per eventuali prenotazioni.</p>`
    if (await hasFutureReservations(ponyID)) {
        modalBody.innerHTML += `<div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="delete-future-reservations-checkbox" />
            <label class="form-check-label" for="delete-future-reservations-checkbox">
                Elimina le prenotazioni future per questo pony
            </label>
        </div>`
    }
    lastHidePonyButtonEventListener = () => { hidePony(ponyID) }
    hidePonyButton.addEventListener('click', lastHidePonyButtonEventListener)
}

async function hidePony(ponyID) {
    const url = 'api/api-pony.php'
    const parameters = new FormData()
    const deleteFutureReservationsCheckbox = document.querySelector('#delete-future-reservations-checkbox')
    parameters.append('action', 'hide')
    parameters.append('pony-id', ponyID)
    parameters.append('delete-future-bookings', deleteFutureReservationsCheckbox !== null && deleteFutureReservationsCheckbox.checked)

    try {
        const response = await fetch(url, {
            method: "POST",
            body: parameters
        })
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const success = await response.json()
        location.replace(location.href.split('?')[0] + `?operation-successful=${success}`)
    } catch (error) {
        console.error(error.message)
    }
}

async function hasFutureReservations(ponyID) {
    const parameters = new URLSearchParams()
    parameters.append('action', 'check-pony-future-reservations')
    parameters.append('pony-id', ponyID)
    const url = `api/api-pony-booking.php?${parameters}`

    try {
        const response = await fetch(url)
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const hasFutureReservations = await response.json()

        return hasFutureReservations
    } catch (error) {
        console.error(error.message)
    }
}

document.querySelector("#make-pony-available-modal").addEventListener('hidden.bs.modal', () => {
    document.querySelector("#make-pony-available-modal .modal-body").innerHTML = ""
    document.querySelector("#make-pony-available-button").removeEventListener('click', lastMakePonyAvailableButtonEventListener)
})

function setMakePonyAvailableModalContent(ponyArticleID) {
    const ponyID = ponyArticleID.replace("pony-", "")
    const ponyName = document.querySelector(`#${ponyArticleID} h3`).innerHTML
    const modalBody = document.querySelector("#make-pony-available-modal .modal-body")
    const makePonyAvailableButton = document.querySelector("#make-pony-available-button")
    modalBody.innerHTML = `<p>Sei sicuro di voler rendere nuovamente disponibile il pony <span class="fw-bold">${ponyName}</span>?</p>
    <p>Il pony sarà visibile dagli studenti e sarà a disposizione per eventuali prenotazioni.</p>`
    lastMakePonyAvailableButtonEventListener = () => { makePonyAvailable(ponyID) }
    makePonyAvailableButton.addEventListener('click', lastMakePonyAvailableButtonEventListener)
}

async function makePonyAvailable(ponyID) {
    const url = 'api/api-pony.php'
    const parameters = new FormData()
    parameters.append('action', 'make-visible')
    parameters.append('pony-id', ponyID)

    try {
        const response = await fetch(url, {
            method: "POST",
            body: parameters
        })
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const success = await response.json()
        location.replace(location.href.split('?')[0] + `?operation-successful=${success}`)
    } catch (error) {
        console.error(error.message)
    }
}

async function fetchPonies(day = null, startTime = null, endTime = null, priceFilter = null) {
    let url = "api/api-pony.php"
    const areAllParamsSet = day !== null && startTime !== null && endTime !== null
    const searchParams = new URLSearchParams()
    if (areAllParamsSet) {
        searchParams.append("day", day)
        searchParams.append("start", startTime)
        searchParams.append("end", endTime)
    }
    if (priceFilter !== null) {
        searchParams.append("price-filter", priceFilter)
    }
    if (searchParams.size > 0) {
        url = `${url}?${searchParams}`
    }
    try {
        const response = await fetch(url)
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const availablePoniesSection = document.querySelector("#available-ponies")
        const hiddenPoniesSection = document.querySelector("#hidden-ponies")
        const result = await response.json()
        const availablePonies = result['ponies'].filter(pony => pony['IsAvailable'])
        const hiddenPonies = result['ponies'].filter(pony => !pony['IsAvailable'])
        if (availablePonies.length > 0) {
            availablePoniesSection.innerHTML = `<h2 class="text-center fs-3 mb-4">Pony disponibili</h2>
            <div class="text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
                ${generatePoniesCards(availablePonies)}
            </div>`
        } else {
            availablePoniesSection.innerHTML = `<h2 class="text-center fs-3 mb-4">Pony disponibili</h2>
            <p class="mt-4 text-center">${result['error-msg']}</p>`
        }
        if (hiddenPonies.length > 0) {
            hiddenPoniesSection.innerHTML = `<h2 class="text-center fs-3 mb-4">Pony nascosti</h2>
            <div class="text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
                ${generatePoniesCards(hiddenPonies)}
            </div>`
        } else {
            hiddenPoniesSection.innerHTML = '<h2 class="text-center fs-3 mb-4">Pony nascosti</h2>'
        }
        document.querySelectorAll('button[data-bs-target="#hide-pony-modal"]').forEach(b => {
            const ponyArticleID = b.parentElement.parentElement.id
            b.addEventListener('click', () => { setHidePonyModalContent(ponyArticleID) })
        })
        document.querySelectorAll('button[data-bs-target="#make-pony-available-modal"]').forEach(b => {
            const ponyArticleID = b.parentElement.parentElement.id
            b.addEventListener('click', () => { setMakePonyAvailableModalContent(ponyArticleID) })
        })
    } catch (error) {
        console.error(error.message)
    }
}

fetchPonies()
