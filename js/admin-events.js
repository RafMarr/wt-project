const main = document.querySelector('main')
const categoryFilter = document.querySelector('#category-filter')

main.classList.add('position-relative')
/* Removing from main tag the bootstrap classes that add padding top and margin top */
main.classList.forEach(c => {
    if (c.match(/pt-\d/) !== null || c.match(/mt-\d/) !== null) {
        main.classList.remove(c)
    }
})

document.querySelector('#resetFiltersBtn').addEventListener('click', () => {
    if (categoryFilter.value !== "all") {
        categoryFilter.value = "all"
        filterEvents(null)
    }
})

categoryFilter.addEventListener('change', () => {
    filterEvents(categoryFilter.value !== "all" ? categoryFilter.value : null)
})

function generateEventsCards(events) {
    let cards = ""
    events.forEach(e => {
        let periodEventsString = ""
        let programmedEventsString = ""
        let placeString = ""

        if (e["Type"] === "A periodo") {
            periodEventsString = `<p class="mb-1"><span class="fw-bold">Data inizio validità:</span> ${Temporal.PlainDate.from(e["StartDate"]).toLocaleString("it-it")}</p>
            <p class="mb-1"><span class="fw-bold">Data fine validità:</span> ${Temporal.PlainDate.from(e["EndDate"]).toLocaleString("it-it")}</p>`
        } else if (e["Type"] === "Programmato") {
            programmedEventsString = `<p class="mb-1"><span class="fw-bold">Data:</span> ${Temporal.PlainDate.from(e["StartDate"]).toLocaleString("it-it")}</p>
            <p class="mb-1"><span class="fw-bold">Orario:</span> ${e["StartTime"].replace(":00", "")}-${e["EndTime"].replace(":00", "")}</p>`
        }

        if (e["Place"] !== null) {
            placeString = `<p class="mb-1"><span class="fw-bold">Luogo:</span> ${e["Place"]}</p>`
        }

        cards += `
        <div class="col">
            <article id="event-${e["EventID"]}" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <h3 class="p-0 m-0 mb-2 fs-4">${e["Title"]}</h3>
                <div class="text-start">
                    ${periodEventsString}
                    ${programmedEventsString}
                    ${placeString}
                    <p class="mb-4 ws-pre-line">${e["Description"]}</p>
                </div>
                <div class="d-flex justify-content-center gap-4 mt-md-auto">
                    <a href="events.php?action=edit&event-id=${e["EventID"]}" class="btn border-0 theme-bg-text">Modifica</a>
                    <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#delete-event-modal">Elimina</button>
                </div>
            </article>
        </div>
        `
    })

    return cards
}

async function filterEvents(categoryFilter) {
    const filtersParameters = new URLSearchParams()
    filtersParameters.append('action', 'filter')
    if (categoryFilter !== null) {
        filtersParameters.append('category', categoryFilter)
    }
    const url = `api/api-events.php?${filtersParameters}`

    try {
        const response = await fetch(url)
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const eventsJson = await response.json()
        const validEventsCards = generateEventsCards(eventsJson['valid-events'])
        const expiredEventsCards = generateEventsCards(eventsJson['expired-events'])
        document.querySelector('#valid-events').innerHTML = validEventsCards
        const expiredEventsDiv = document.querySelector('#expired-events')
        if (expiredEventsDiv !== null) {
            expiredEventsDiv.innerHTML = expiredEventsCards
        }
    } catch (error) {
        console.error(error.message)
    }
}
