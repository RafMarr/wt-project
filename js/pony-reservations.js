const main = document.querySelector('main')
const bookingDeletionModal = document.querySelector('#booking-deletion-modal')
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

document.querySelectorAll('section button').forEach(button => {
    const referredReservationID = button.parentElement.parentElement.id
    button.addEventListener('click', () => { setBookingDeletionModalContent(referredReservationID) })
})
