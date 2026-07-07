const inputDate = document.getElementById("data-filtro");
const selectAnno = document.getElementById("anno-filtro");
const divContainer = document.getElementById("lesson-container");

let lessons = [];

function updateDivLessons() {
    divContainer.innerHTML = "";
    lessons.forEach(lesson => {
        divContainer.innerHTML += `<div class="row justify-content-center border-mode-text border-solid rounded mode-gray col-10 col-md-5 col-xl-3 m-2">
                                    <div class="row justify-content-between border-b border-mode-text col-12">
                                        <div class="row col-3 align-items-center row-gap-2">
                                            <p class="col-12 p-0 m-0">${lesson.StartTime.slice(0, 5)}</p>
                                            <p class="col-12 p-0 m-0">${lesson.EndTime.slice(0, 5)}</p>
                                        </div>
                                        <div class="col-9 d-flex align-items-center justify-content-center">
                                            <h3 class="fs-4 my-1"><a class="mode-text" href="#">${lesson.CourseName}</a></h3>
                                        </div>
                                    </div>
                                    <div class="row align-items-center row-gap-2 col-12 my-1">
                                        <p class="col-12 m-0"><strong>Aula</strong>: ${lesson.PlaceName}</p>
                                        <p class="col-12 m-0"><strong>Docente</strong>: ${lesson.Date}</p>
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
