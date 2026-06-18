const resetFiltersButton = document.getElementById('resetFiltersBtn')
const priceFilter = document.getElementById('priceFilter')
const dateInput = document.querySelector('#day')
const startTimeInput = document.querySelector('#start-time')
const endTimeInput = document.querySelector('#end-time')
const allInputs = Array.from(document.querySelectorAll('#booking-params input'))
const bookingModal = document.querySelector('#booking-modal')
const SATURDAY = 6
const HIPPODROME_OPENING_TIME = document.querySelector("#mon-fri-hours > time:first-of-type").innerHTML
const HIPPODROME_WEEKDAYS_CLOSING_TIME = document.querySelector("#mon-fri-hours > time:last-of-type").innerHTML
const HIPPODROME_WEEKEND_CLOSING_TIME = document.querySelector("#sat-sun-hours > time:last-of-type").innerHTML

resetFiltersButton.addEventListener('click', () => {
    priceFilter.value = "all"
    /* this instruction triggers the "change" event on priceFilter, in order to
       update the page content after filter reset */
    priceFilter.dispatchEvent(new Event('change'))
})

function setInputStyleBasedOnValidity(input) {
    /* the length check is needed because checkValidity() returns true if the input value is an empty string */
    if (input.value.length > 0 && input.checkValidity()) {
        input.classList.remove('is-invalid')
        input.classList.add('is-valid')
        input.classList.add('mb-md-feedback')
    } else {
        input.classList.remove('is-valid')
        input.classList.add('is-invalid')
        input.classList.remove('mb-md-feedback')
    }
}

function setInvalidFeedbackContent(input) {
    const invalidFeedbackElement = document.getElementById(input.getAttribute('aria-describedby'))
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

function setEndTimeInputMinValue() {
    if (startTimeInput.value.length > 0 && startTimeInput.checkValidity()) {
        endTimeInput.setAttribute('min', startTimeInput.value)
    } else {
        endTimeInput.setAttribute('min', HIPPODROME_OPENING_TIME)
    }
}

function isInputValid(input) {
    return input.value.length > 0 && input.checkValidity()
}

allInputs.forEach(input => {
    input.addEventListener('change', () => {
        setInputStyleBasedOnValidity(input)

        /* TODO: ogni volta che un input cambia, anche se devono essere mostrati sempre gli stessi pony di prima,
        viene fatta una nuova richiesta al database. Risolvere questo problema per evitare un eccessivo
        sovraccarico del database */
        if (allInputs.every(input => isInputValid(input))) {
            fetchPonies(dateInput.value, startTimeInput.value, endTimeInput.value)
        } else {
            fetchPonies()
        }
    })
})

dateInput.addEventListener('change', () => {

    /* TODO: la mia intenzione con il seguente codice è quella di settare l'attributo "min" all'ora corrente per gli input di tipo "time"
     quando la data selezionata nell'input di tipo "date" è la data di oggi, in modo tale da non rendere selezionabili gli orari "precedenti".
    */

    // if (Temporal.PlainDate.compare(Temporal.PlainDate.from(dateInput.value), Temporal.Now.plainDateISO()) == 0) {
    //     startTimeInput.setAttribute('min', Temporal.Now.plainTimeISO().toString())
    //     endTimeInput.setAttribute('min', Temporal.Now.plainTimeISO().toString())
    // } else {
    //     if (startTimeInput.hasAttribute('min')) {
    //         startTimeInput.removeAttribute('min')
    //     }
    //     if (endTimeInput.hasAttribute('min')) {
    //         endTimeInput.removeAttribute('min')
    //     }
    // }

    if (dateInput.value.length > 0 && dateInput.checkValidity()) {
        const dateSet = Temporal.PlainDate.from(dateInput.value)
        if (dateSet.dayOfWeek < SATURDAY) {
            startTimeInput.setAttribute('max', HIPPODROME_WEEKDAYS_CLOSING_TIME)
            endTimeInput.setAttribute('max', HIPPODROME_WEEKDAYS_CLOSING_TIME)
        } else {
            startTimeInput.setAttribute('max', HIPPODROME_WEEKEND_CLOSING_TIME)
            endTimeInput.setAttribute('max', HIPPODROME_WEEKEND_CLOSING_TIME)
        }
    }

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

bookingModal.addEventListener('hidden.bs.modal', () => {
    document.querySelector("#booking-modal .modal-body").innerHTML = ""
    document.querySelector("#booking-modal .modal-footer button").removeEventListener('click', bookPony)
})

async function bookPony(ponyID, bookingDate, startTime, endTime) {
    // TODO: fare la richiesta con fetch al file api-pony-booking.php
}

function setBookingModalContent(ponyArticleID) {
    const MINUTES_IN_HOUR = 60
    const PRICE_FRACTION_DIGITS = 2
    const modalBody = document.querySelector("#booking-modal .modal-body")
    const bookingButton = document.querySelector("#booking-modal .modal-footer button")
    const bookingDate = Temporal.PlainDate.from(dateInput.value) // dateInput.value is assumed to be not null or empty
    const ponyName = document.querySelector(`#${ponyArticleID} h4`).innerHTML
    const ponyHourlyFee = Array.from(document.querySelectorAll(`#${ponyArticleID} p`)).filter(p => p.innerText.includes("Costo: "))[0].innerText.replace("Costo: ", "")
    const ponyID = ponyArticleID.replace("pony-", "")
    const startTime = Temporal.PlainTime.from(startTimeInput.value)
    const endTime = Temporal.PlainTime.from(endTimeInput.value)
    const bookingDuration = endTime.since(startTime)
    const bookingDurationInHours = bookingDuration.hours + (bookingDuration.minutes / MINUTES_IN_HOUR)
    const bookingPrice = (bookingDurationInHours * parseFloat(ponyHourlyFee)).toFixed(PRICE_FRACTION_DIGITS)
    modalBody.innerHTML = `<p class="mb-1"><span class="fw-bold">Pony scelto:</span> ${ponyName}</p>
    <p class="mb-1"><span class="fw-bold">Data prenotazione:</span> ${bookingDate.day}/${bookingDate.month}/${bookingDate.year}</p>
    <p class="mb-1"><span class="fw-bold">Orario:</span> ${startTimeInput.value}-${endTimeInput.value}</p>
    <p class="mb-1"><span class="fw-bold">Prezzo:</span> ${ponyHourlyFee}</p>
    <div class="text-end pe-2 mt-3"><p class="m-0 fs-5"><span class="fw-bold">Totale:</span> € ${bookingPrice}</p></div>`
    bookingButton.addEventListener('click', bookPony(ponyID, bookingDate, startTime, endTime))
}

function generatePoniesCards(ponies, enableBookingButtons = false) {
    let cards = "";

    ponies.forEach(pony => {
        let specMarksRow = ""
        let descriptionRow = ""

        if (pony["SpecMarks"] != null) {
            const marginBottomSpecMarks = pony["Description"] != null ? 'mb-1' : 'mb-4'
            specMarksRow = `<p class="${marginBottomSpecMarks}"><span class="fw-bold">Segni particolari:</span> ${pony["SpecMarks"]}</p>`
        }

        if (pony["Description"] != null) {
            descriptionRow = `<p class="mb-4"><span class="fw-bold">Descrizione:</span> ${pony["Description"]}</p>`
        }

        const marginBottomHourlyFee = (pony["SpecMarks"] == null && pony["Description"] == null) ? 'mb-4' : 'mb-1'

        let bookingButton
        if (enableBookingButtons) {
            bookingButton = `<button type="button" onclick='setBookingModalContent("pony-${pony["PonyID"]}")' class="btn theme-bg-text" data-bs-toggle="modal" data-bs-target="#booking-modal">Prenota</button>`
        } else {
            bookingButton = '<button type="button" class="btn opacity-50 theme-bg-text" disabled>Prenota</button>'
        }

        cards += `
        <div class="col">
            <article id="pony-${pony["PonyID"]}" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <!-- "alt" attribute is left empty as described in: https://html.spec.whatwg.org/dev/images.html#ancillary-images -->
                    <img src="${pony["Image"]}" class="img-fluid w-75 rounded-2" alt="">
                    <h4 class="p-0 m-0 mt-3 mb-2">${pony["Name"]}</h4>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> ${pony["Breed"]}</p>
                    <p class="${marginBottomHourlyFee}"><span class="fw-bold">Costo:</span> ${pony["HourlyFee"]} €/ora</p>
                    ${specMarksRow}
                    ${descriptionRow}
                </div>
                <div class="text-center m-0 mt-md-auto">
                    ${bookingButton}
                </div>
            </article>
        </div>
        `
    });

    return cards
}

async function fetchPonies(day = null, startTime = null, endTime = null) {
    let url = "api/api-pony.php"
    const areAllParamsSet = day != null && startTime != null && endTime != null
    if (areAllParamsSet) {
        const searchParams = new URLSearchParams()
        searchParams.append("day", day)
        searchParams.append("start", startTime)
        searchParams.append("end", endTime)
        url = `${url}?${searchParams}`
    }
    try {
        const response = await fetch(url)
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const availablePoniesSection = document.querySelector("#available-ponies")
        availablePoniesSection.innerHTML = '<h3 class="visually-hidden">Pony disponibili</h3>'
        const poniesJson = await response.json()
        if (poniesJson.length > 0) {
            /* The booking buttons must be enabled only if the user has filled all the required fields */
            const poniesCards = generatePoniesCards(poniesJson, areAllParamsSet)
            availablePoniesSection.innerHTML += poniesCards
        } else {
            availablePoniesSection.innerHTML += '<p class="my-0 mx-auto">Non ci sono pony disponibili</p>'
        }
    } catch (error) {
        console.error(error.message)
    }
}

fetchPonies()
