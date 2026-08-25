const main = document.querySelector('main')
const defaultCategoryRadioBtn = document.querySelector('#category-all')
const defaultContractTypeRadioBtn = document.querySelector('#contract-type-all')

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
    let fetchJobPosts = false

    if (!defaultCategoryRadioBtn.checked) {
        defaultCategoryRadioBtn.checked = true
        fetchJobPosts = true
    }

    if (!defaultContractTypeRadioBtn.checked) {
        defaultContractTypeRadioBtn.checked = true
        fetchJobPosts = true
    }

    if (fetchJobPosts) {
        filterJobPosts(null, null)
    }
})

function getCategoryFilterValue() {
    const selectedValue = document.querySelector('input[name="category"]:checked').value
    return selectedValue !== "all" ? selectedValue : null
}

function getContractTypeFilterValue() {
    const selectedValue = document.querySelector('input[name="contract-type"]:checked').value
    return selectedValue !== "all" ? selectedValue : null
}

document.querySelectorAll('input[name="category"]').forEach(i => {
    i.addEventListener('change', () => {
        filterJobPosts(i.value !== "all" ? i.value : null, getContractTypeFilterValue())
    })
})

document.querySelectorAll('input[name="contract-type"]').forEach(i => {
    i.addEventListener('change', () => {
        filterJobPosts(getCategoryFilterValue(), i.value !== "all" ? i.value : null)
    })
})

function generateJobPostsCards(jobPosts) {
    cards = ""
    jobPosts.forEach(jp => {
        cards += `
        <div class="col">
            <article id="${jp["JobPostID"]}" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <h2 class="p-0 m-0 mb-2 fs-3">${jp["Title"]}</h2>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Data inserimento:</span> ${Temporal.PlainDate.from(jp["InsertionDate"]).toLocaleString("it-it")}</p>
                    <p class="mb-1"><span class="fw-bold">Impresa:</span> ${jp["Author"]}</p>
                    <p class="mb-1 ws-pre-line"><span class="fw-bold">Descrizione:</span> ${jp["Description"]}</p>
                    <p class="mb-1 ws-pre-line"><span class="fw-bold">Orari di lavoro:</span> ${jp["WorkingTime"]}</p>
                    <p class="mb-1"><span class="fw-bold">Indirizzo:</span> ${jp["EnterpriseAddress"]}</p>
                    <p class="mb-1"><span class="fw-bold">Paga oraria:</span> € ${jp["HourlySalary"]}</p>
                    <p class="mb-1"><span class="fw-bold">Tipologia contratto:</span> ${jp["ContractType"]}</p>
                    <address class="mb-4">
                        <p class="mb-1"><span class="fw-bold">Recapito telefonico:</span> ${jp["AuthorPhoneNumber"]}</p>
                        <p><span class="fw-bold">Email:</span> <a href="mailto:${jp["AuthorEmail"]}">${jp["AuthorEmail"]}</a></p>
                    </address>
                </div>
            </article>
        </div>
        `
    })
    
    document.querySelector("section > div").innerHTML = cards
}

async function filterJobPosts(categoryFilter, contractTypeFilter) {
    const filtersParameters = new URLSearchParams()
    filtersParameters.append('action', 'filter')
    if (categoryFilter !== null) {
        filtersParameters.append('category', categoryFilter)
    }
    if (contractTypeFilter !== null) {
        filtersParameters.append('contract-type', contractTypeFilter)
    }
    const url = `api/api-job-posts.php?${filtersParameters}`

    try {
        const response = await fetch(url)
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const jobPosts = await response.json()
        generateJobPostsCards(jobPosts)
    } catch (error) {
        console.error(error.message)
    }
}
