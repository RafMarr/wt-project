const inputDate = document.getElementById("data-filtro");
const selectAnno = document.getElementById("anno-filtro");
const divContainer = document.getElementById("lesson-container");

let lessons = [];

function updateDivLessons() {
    divContainer.innerHTML = "";
    lessons.forEach(lesson => {
        divContainer.innerHTML += `<div class="row justify-content-center border-mode-gray border-2 border-solid rounded mode-gray lesson-card-md col-10 p-2">
                                    <div class="row justify-content-between justify-content-md-start border-b-2 border-mode-gray border-md-0 col-12 mb-1">
                                        <div class="d-flex col-3 align-items-center text-md-start m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clock-fill d-none d-md-inline col-md-2 p-0" viewBox="0 0 16 16" aria-label="Orario:">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                            </svg>
                                            <div class="d-md-flex col-12 col-md-10 p-0 m-0">
                                                <p class="p-0 m-0">${lesson.StartTime.slice(0, 5)}</p>
                                                <span class="d-none d-md-inline p-0">-</span>
                                                <p class="p-0 m-0">${lesson.EndTime.slice(0, 5)}</p>
                                            </div>
                                        </div>
                                        <div class="col-9 d-flex align-items-center justify-content-start text-start">
                                            <h2 class="fs-4 my-1"><a class="mode-text" href="courses.php?courseID=${lesson.CourseID}">${lesson.CourseName}</a></h2>
                                        </div>
                                    </div>
                                    <div class="row align-items-center row-gap-2 col-12 my-1 justify-content-md-start">
                                        <div class="col-12 col-md-3 text-start m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill d-none d-md-inline col-md-2" viewBox="0 0 16 16" aria-label="Aula:">
                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                            </svg>
                                            <p class="d-md-inline col-md-10 m-0"><span class="d-md-none"><strong>Aula</strong>: </span>${lesson.PlaceName}</p>
                                        </div>
                                        <p class="col-12 col-md-9 text-start m-0"><strong>Docente</strong>: ${lesson.ProfName} ${lesson.ProfSurname} (Modulo ${lesson.Module})</p>
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
