const inputDate = document.getElementById("data-filtro");
const selectAnno = document.getElementById("anno-filtro");
const divContainer = document.getElementById("lesson-container");

let lessons = [];

function updateDivLessons() {
    divContainer.innerHTML = "";
    lessons.forEach(lesson => {
        divContainer.innerHTML += `<div class="row justify-content-center border-mode-text border-solid rounded mode-gray lesson-card-md col-10 p-2">
                                    <div class="row justify-content-between justify-content-md-start border-b border-mode-text border-md-0 col-12">
                                        <div class="row col-3 align-items-center row-gap-2 m-0">
                                            <div class="d-none d-md-inline col-2 p-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                                </svg>
                                            </div>
                                            <p class="col-12 col-md-5 p-0 m-0">${lesson.StartTime.slice(0, 5)}</p>
                                            <p class="col-12 col-md-5 p-0 m-0">${lesson.EndTime.slice(0, 5)}</p>
                                        </div>
                                        <div class="col-9 d-flex align-items-center justify-content-center justify-content-md-start">
                                            <h3 class="fs-4 my-1"><a class="mode-text" href="#">${lesson.CourseName}</a></h3>
                                        </div>
                                    </div>
                                    <div class="row align-items-center row-gap-2 col-12 my-1 justify-content-md-start">
                                        <p class="col-12 col-md-3 text-md-start m-0"><strong>Aula</strong>: ${lesson.PlaceName}</p>
                                        <p class="col-12 col-md-9 text-md-start m-0"><strong>Docente</strong>: ${lesson.Date}</p>
                                    </div>
                                </div>`
    });
}

async function fetchLessons() {
    const date = inputDate.value;
    let year = parseInt(selectAnno.value);
    lessons = [];
    updateDivLessons();

    const url = "api/api-get-lessons.php";
    const formData = new FormData();
    formData.append('date', date);
    formData.append('year', year);
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        lessons = await response.json();

        updateDivLessons();
    } catch (error) {
        console.log(error.message);
    }
}

inputDate.addEventListener("change", fetchLessons);
selectAnno.addEventListener("change", fetchLessons);
