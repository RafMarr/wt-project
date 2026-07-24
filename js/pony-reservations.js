main = document.querySelector('main')

main.classList.add('position-relative')
/* Removing from main tag the bootstrap classes that add padding top and margin top */
main.classList.forEach(c => {
    if (c.match(/pt-\d/) !== null || c.match(/mt-\d/) !== null) {
        main.classList.remove(c)
    }
})

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
    const referredReservation = button.parentElement.parentElement.id
    button.addEventListener('click', () => {
        deletePonyBooking(referredReservation)
    })
})
