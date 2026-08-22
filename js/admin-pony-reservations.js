const main = document.querySelector('main')
const bookingDeletionModal = document.querySelector('#booking-deletion-modal')
const studentIdFilter = document.querySelector('#student-id-filter')
const ponyNameFilter = document.querySelector('#pony-name-filter')
const defaultAvailabilityRadioBtn = document.querySelector('#pony-availability-all')
const STUDENT_ID_LENGTH = 10
/* This variable is the reference to the anonymous function that is used as the
click event handler for the booking deletion button in the #booking-deletion-modal modal.
In this way, it is possible to remove the event listener attached to the booking
deletion button when the modal is closed.
More information on this topic can be found here:
https://dev.to/smotchkkiss/function-identity-in-javascript-or-how-to-remove-event-listeners-properly-1ll3 */
let lastBookingDeletionButtonClickEventListener = null

main.classList.add('position-relative')
/* Removing from main tag the bootstrap classes that add padding top and margin top */
main.classList.forEach(c => {
    if (c.match(/pt-\d/) !== null || c.match(/mt-\d/) !== null) {
        main.classList.remove(c)
    }
})

document.querySelector('#resetFiltersBtn').addEventListener('click', () => {
    /* This variable is true if at least one of the filters must be reset, 
       and so must be done the request to the server */
    let fetchReservations = false

    if (studentIdFilter.value.length === STUDENT_ID_LENGTH) {
        fetchReservations = true
    }
    studentIdFilter.value = ""

    if (ponyNameFilter.value != "all") {
        ponyNameFilter.value = "all"
        fetchReservations = true
    }

    if (!defaultAvailabilityRadioBtn.checked) {
        defaultAvailabilityRadioBtn.checked = true
        fetchReservations = true
    }

    if (fetchReservations) {
        filterReservations(null, null, null)
    }
})

function getAvailabilityFilterValue() {
    const selectedValue = document.querySelector('input[name="pony-availability"]:checked').value
    return selectedValue !== "all" ? selectedValue : null
}

function getStudentIdFilterValue() {
    return studentIdFilter.value.length === STUDENT_ID_LENGTH ? studentIdFilter.value : null
}

function getPonyNameFilterValue() {
    return ponyNameFilter.value !== "all" ? ponyNameFilter.value : null
}

studentIdFilter.addEventListener('change', () => {
    filterReservations(getStudentIdFilterValue(), getPonyNameFilterValue(), getAvailabilityFilterValue())
})

ponyNameFilter.addEventListener('change', () => {
    filterReservations(getStudentIdFilterValue(), getPonyNameFilterValue(), getAvailabilityFilterValue())
})

document.querySelectorAll('input[name="pony-availability"]').forEach(i => {
    i.addEventListener('change', () => {
        filterReservations(getStudentIdFilterValue(), getPonyNameFilterValue(), i.value !== "all" ? i.value : null)
    })
})

bookingDeletionModal.addEventListener('hidden.bs.modal', () => {
    document.querySelector("#booking-deletion-modal .modal-body").innerHTML = ""
    document.querySelector("#booking-deletion-button").removeEventListener('click', lastBookingDeletionButtonClickEventListener)
})

function setBookingDeletionModalContent(reservationID) {
    const modalBody = document.querySelector('#booking-deletion-modal .modal-body')
    const bookingDeletionButton = document.querySelector('#booking-deletion-button')
    modalBody.innerHTML = `<p>Sei sicuro di voler eliminare la prenotazione #${reservationID}?</p>`
    lastBookingDeletionButtonClickEventListener = () => { deletePonyBooking(reservationID) }
    bookingDeletionButton.addEventListener('click', lastBookingDeletionButtonClickEventListener)
}

async function deletePonyBooking(bookingID) {
    const url = 'api/api-pony-booking.php'
    const parameters = new FormData()
    parameters.append('action', "delete-booking")
    parameters.append('booking-id', bookingID)

    try {
        const response = await fetch(url, {
            method: "POST",
            body: parameters
        })
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const isDeletionSuccessful = await response.json()
        location.replace(location.href.split('?')[0] + `?deletion-successful=${isDeletionSuccessful}`)
    } catch (error) {
        console.error(error.message)
    }
}

function setDeletionButtonsClickEventListener() {
    document.querySelectorAll('section button').forEach(button => {
        const referredReservationID = button.parentElement.parentElement.id
        button.addEventListener('click', () => { setBookingDeletionModalContent(referredReservationID) })
    })
}

function generateReservationsCards(reservations) {
    cards = ""
    reservations.forEach(r => {
        cards += `
        <div class="col">
            <article id="${r["ReservationID"]}" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <h2 class="p-0 m-0 mb-2 fs-3">Prenotazione #${r["ReservationID"]}</h2>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Pony:</span> ${r["PonyName"]}</p>
                    <p class="mb-1"><span class="fw-bold">Data:</span> ${Temporal.PlainDate.from(r["Date"]).toLocaleString("it-it")}</p>
                    <p class="mb-1"><span class="fw-bold">Ora inizio:</span> ${r["StartHour"].replace(":00", "")}</p>
                    <p class="mb-1"><span class="fw-bold">Ora fine:</span> ${r["EndHour"].replace(":00", "")}</p>
                    <p class="mb-1"><span class="fw-bold">Matricola studente:</span> ${r["StudentID"]}</p>
                    <p class="mb-1"><span class="fw-bold">Nome studente:</span> ${r["StudentName"]} ${r["StudentSurname"]}</p>
                    <p class="mb-1"><span class="fw-bold">Email studente:</span> ${r["Email"]}</p>
                    <p class="mb-4"><span class="fw-bold">Totale:</span> € ${r["PaidAmount"]}</p>
                </div>
                <div class="text-center m-0 mt-md-auto">
                    <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#booking-deletion-modal">Cancella prenotazione</button>
                </div>
            </article>
        </div>
        `
    })
    
    document.querySelector("section > div").innerHTML = cards
    setDeletionButtonsClickEventListener()
}

async function filterReservations(studentIdFilter, ponyNameFilter, availabilityFilter) {
    const url = 'api/api-pony-booking.php'
    const filtersParameters = new FormData()
    filtersParameters.append('action', 'filter')
    filtersParameters.append('period', 'future')
    if (studentIdFilter !== null) {
        filtersParameters.append('student-id', studentIdFilter)
    }
    if (ponyNameFilter !== null) {
        filtersParameters.append('pony-name', ponyNameFilter)
    }
    if (availabilityFilter !== null) {
        filtersParameters.append('pony-availability', availabilityFilter)
    }

    try {
        const response = await fetch(url, {
            method: "POST",
            body: filtersParameters
        })
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const reservations = await response.json()
        generateReservationsCards(reservations)
    } catch (error) {
        console.error(error.message)
    }
}

setDeletionButtonsClickEventListener()
