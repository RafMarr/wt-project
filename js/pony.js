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
const MINIMUM_BOOKING_DURATION = Temporal.Duration.from({ minutes: 30 })
const HIPPODROME_WEEKDAYS_LAST_BOOKING_START_TIME = Temporal.PlainTime.from(HIPPODROME_WEEKDAYS_CLOSING_TIME).subtract(MINIMUM_BOOKING_DURATION).toString().slice(0, 5)
const HIPPODROME_WEEKEND_LAST_BOOKING_START_TIME = Temporal.PlainTime.from(HIPPODROME_WEEKEND_CLOSING_TIME).subtract(MINIMUM_BOOKING_DURATION).toString().slice(0, 5)
/* The following variable is used to refresh the available ponies information only when needed */
let lastInputValidityCheckResult = false
/* This variable is the reference to the anonymous function that is used as the
click event handler for the booking button in the #booking-modal modal.
In this way, it is possible to remove the event listener attached to the booking
button when the booking modal is closed.
More information on this topic can be found here:
https://dev.to/smotchkkiss/function-identity-in-javascript-or-how-to-remove-event-listeners-properly-1ll3 */
let lastBookingButtonClickEventListener = null

/* This event listener solves the warning raised by Chrome when a modal is
   closed but one of his descendants retains focus */
document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener('hide.bs.modal', () => {
        if (document.activeElement) {
            document.activeElement.blur()
        }
    })
})

document.querySelector('main').classList.add('position-relative')

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

function getHippodromeLastBookingStartTime(date) {
    if (date instanceof Temporal.PlainDate) {
        return date.dayOfWeek >= SATURDAY ? HIPPODROME_WEEKEND_LAST_BOOKING_START_TIME : HIPPODROME_WEEKDAYS_LAST_BOOKING_START_TIME
    } else {
        throw new TypeError('The parameter type must be Temporal.PlainDate')
    }
}

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
        startTimeInput.setAttribute('min', currentTimeString >= HIPPODROME_OPENING_TIME && currentTimeString <= getHippodromeLastBookingStartTime(Temporal.PlainDate.from(dateInput.value)) ? currentTimeString : HIPPODROME_OPENING_TIME)
    } else {
        startTimeInput.setAttribute('min', HIPPODROME_OPENING_TIME)
    }
}

function setEndTimeInputMinValue() {
    if (isInputValid(startTimeInput)) {
        endTimeInput.setAttribute('min', Temporal.PlainTime.from(startTimeInput.value).add(MINIMUM_BOOKING_DURATION).toString().slice(0, 5))
    } else if (hasCurrentDate(dateInput)) {
        const currentTime = Temporal.Now.plainTimeISO()
        const currentTimeString = currentTime.toString().slice(0, 5)
        endTimeInput.setAttribute('min', currentTimeString >= HIPPODROME_OPENING_TIME && currentTimeString <= getHippodromeClosingTime(Temporal.PlainDate.from(dateInput.value)) ? currentTime.add(MINIMUM_BOOKING_DURATION).toString().slice(0, 5) : HIPPODROME_OPENING_TIME)
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
            startTimeInput.setAttribute('max', HIPPODROME_WEEKDAYS_LAST_BOOKING_START_TIME)
            endTimeInput.setAttribute('max', HIPPODROME_WEEKDAYS_CLOSING_TIME)
        } else {
            startTimeInput.setAttribute('max', HIPPODROME_WEEKEND_LAST_BOOKING_START_TIME)
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

bookingModal.addEventListener('hidden.bs.modal', () => {
    document.querySelector("#booking-modal .modal-body").innerHTML = ""
    document.querySelector("#booking-modal .modal-footer button").removeEventListener('click', lastBookingButtonClickEventListener)
})

async function bookPony(ponyID, bookingDate, startTime, endTime) {
    const url = 'api/api-pony-booking.php'
    const bookingParameters = new FormData()
    bookingParameters.append('ponyID', ponyID)
    bookingParameters.append('day', bookingDate)
    bookingParameters.append('start', startTime)
    bookingParameters.append('end', endTime)

    try {
        const response = await fetch(url, {
            method: "POST",
            body: bookingParameters
        })
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const isBookingSuccessful = await response.json()
        location.replace(location.href.split('?')[0] + `?booking-successful=${isBookingSuccessful}`)
    } catch (error) {
        console.error(error.message)
    }
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
    lastBookingButtonClickEventListener = () => { bookPony(ponyID, dateInput.value, startTimeInput.value, endTimeInput.value) }
    bookingButton.addEventListener('click', lastBookingButtonClickEventListener)
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
            bookingButton = `<button type="button" onclick='setBookingModalContent("pony-${pony["PonyID"]}")' class="btn border-0 theme-bg-text" data-bs-toggle="modal" data-bs-target="#booking-modal">Prenota</button>`
        } else {
            bookingButton = '<button type="button" class="btn border-0 opacity-50 theme-bg-text" disabled>Prenota</button>'
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
        availablePoniesSection.innerHTML = '<h3 class="visually-hidden">Pony disponibili</h3>'
        const result = await response.json()
        if (result['ponies'].length > 0) {
            /* The booking buttons must be enabled only if the user has filled all the required fields */
            const poniesCards = generatePoniesCards(result['ponies'], areAllParamsSet)
            availablePoniesSection.innerHTML += poniesCards
        } else {
            availablePoniesSection.innerHTML += `<p class="my-0 mx-auto">${result['error-msg']}</p>`
        }
    } catch (error) {
        console.error(error.message)
    }
}

fetchPonies()
