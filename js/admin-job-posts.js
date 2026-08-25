const main = document.querySelector('main')
const categoryFilter = document.querySelector('#category-filter')
const defaultContractTypeRadioBtn = document.querySelector('#contract-type-all')
/* This variable is the reference to the anonymous function that is used as the
click event handler for the job post deletion button in the #delete-job-post-modal modal.
In this way, it is possible to remove the event listener attached to the job post
deletion button when the modal is closed.
More information on this topic can be found here:
https://dev.to/smotchkkiss/function-identity-in-javascript-or-how-to-remove-event-listeners-properly-1ll3 */
let lastDeleteJobPostButtonEventListener = null

main.classList.add('position-relative')
/* Removing from main tag the bootstrap classes that add padding top and margin top */
main.classList.forEach(c => {
    if (c.match(/pt-\d/) !== null || c.match(/mt-\d/) !== null) {
        main.classList.remove(c)
    }
})

document.querySelector('#delete-job-post-modal').addEventListener('hidden.bs.modal', () => {
    document.querySelector("#delete-job-post-modal .modal-body").innerHTML = ""
    document.querySelector("#delete-job-post-button").removeEventListener('click', lastDeleteJobPostButtonEventListener)
})

document.querySelector('#resetFiltersBtn').addEventListener('click', () => {
    /* This variable is true if at least one of the filters must be reset, 
       and so must be done the request to the server */
    let fetchJobPosts = false

    if (!categoryFilter.value !== "all") {
        categoryFilter.value = "all"
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
    return categoryFilter.value !== "all" ? categoryFilter.value : null
}

function getContractTypeFilterValue() {
    const selectedValue = document.querySelector('input[name="contract-type"]:checked').value
    return selectedValue !== "all" ? selectedValue : null
}

categoryFilter.addEventListener('change', () => {
    filterJobPosts(getCategoryFilterValue(), getContractTypeFilterValue())
})

document.querySelectorAll('input[name="contract-type"]').forEach(i => {
    i.addEventListener('change', () => {
        filterJobPosts(getCategoryFilterValue(), i.value !== "all" ? i.value : null)
    })
})

function setJobPostDeletionModalContent(jobPostArticleID) {
    const modalBody = document.querySelector('#delete-job-post-modal .modal-body')
    const deletionButton = document.querySelector('#delete-job-post-button')
    const jobPostTitle = document.querySelector(`#${jobPostArticleID} h2`).innerText
    const jobPostAuthor = document.querySelector(`#${jobPostArticleID}-author`).innerText.replace("Impresa: ", "")
    const jobPostID = jobPostArticleID.replace("job-post-", "")
    modalBody.innerHTML = `<p>Sei sicuro di voler eliminare l'annuncio "${jobPostTitle}" di ${jobPostAuthor}?</p>`
    lastDeleteJobPostButtonEventListener = () => { deleteJobPost(jobPostID) }
    deletionButton.addEventListener('click', lastDeleteJobPostButtonEventListener)
}

async function deleteJobPost(jobPostID) {
    const url = 'api/api-job-posts.php'
    const parameters = new FormData()
    parameters.append('action', "delete")
    parameters.append('job-post-id', jobPostID)

    try {
        const response = await fetch(url, {
            method: "POST",
            body: parameters
        })
        if (!response.ok) {
            throw new Error("Response status: " + response.status)
        }
        const isDeletionSuccessful = await response.json()
        location.replace(location.href.split('?')[0] + `?operation-successful=${isDeletionSuccessful}`)
    } catch (error) {
        console.error(error.message)
    }
}

function setDeletionButtonsClickEventListener() {
    document.querySelectorAll('button[data-bs-target="#delete-job-post-modal"]').forEach(button => {
        const jobPostArticleID = button.parentElement.parentElement.id
        button.addEventListener('click', () => { setJobPostDeletionModalContent(jobPostArticleID) })
    })
}

function generateJobPostsCards(jobPosts) {
    cards = ""
    jobPosts.forEach(jp => {
        cards += `
        <div class="col">
            <article id="job-post-${jp["JobPostID"]}" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <h2 class="p-0 m-0 mb-2 fs-3">${jp["Title"]}</h2>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Data inserimento:</span> ${Temporal.PlainDate.from(jp["InsertionDate"]).toLocaleString("it-it")}</p>
                    <p class="mb-1" id="job-post-${jp["JobPostID"]}-author"><span class="fw-bold">Impresa:</span> ${jp["Author"]}</p>
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
                <div class="d-flex justify-content-center gap-4 mt-md-auto">
                    <a href="job-posts.php?action=edit&job-post-id=${jp["JobPostID"]}" class="btn border-0 theme-bg-text">Modifica</a>
                    <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#delete-job-post-modal">Elimina</button>
                </div>
            </article>
        </div>
        `
    })

    document.querySelector("#job-posts").innerHTML = cards
    setDeletionButtonsClickEventListener()
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

setDeletionButtonsClickEventListener()
