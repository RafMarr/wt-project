const selectDegree = document.getElementById("degree-select");

const divSmallMediaContainer = document.getElementById("small-media-container");
const divMediumMediaContainer = document.getElementById("medium-media-container");

let courses = [];
let unfilteredCourses = [];

async function fetchCourses() {
    unfilteredCourses = [];

    const url = "api/api-get-courses.php";
    const formData = new FormData();
    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        unfilteredCourses = await response.json();

    } catch (error) {
        console.log(error.message);
    }
}

function filterCoursesByDegree() {
    if (selectDegree.value === "0") {
        courses = [...unfilteredCourses];
    } else {
        courses = unfilteredCourses.filter(corso => corso.DegreeCourseID === parseInt(selectDegree.value));
    }
}

fetchCourses();
selectDegree.addEventListener("change", () => {
    filterCoursesByDegree();
    updateDivCourses();
});

function smallMediaSectionTemplate(id, target, h2, year, degreeType) {
    let result = `<div class="accordion mb-5 mx-auto" id="${id}">
                    <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${target}" aria-expanded="false" aria-controls="${target}">
                        ${h2}
                        </button>
                    </h2>
                    <div id="${target}" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#${id}">
                        <div class="accordion-body text-start mode-bg-text">
                        <section class="pt-3">
                            <h3>Primo Semestre</h3>
                            <ul class="list-style-none px-2 m-0">`;
    courses.forEach(corso => {
        if (corso.Year === year && corso.Semester === 1 && corso.Type === degreeType) {
        result += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
        }
    });
    result +=               `</ul>
                        </section>
                        <section class="pt-3">
                            <h3>Secondo Semestre</h3>
                            <ul class="list-style-none px-2 m-0">`;
    courses.forEach(corso => {
        if (corso.Year === year && corso.Semester === 2 && corso.Type === degreeType) {
        result += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
        }
    });
    result +=               `</ul>
                        </section>
                        </div>
                    </div>
                    </div>
                </div>`;
    return result;
}

function mediumMediaSectionTemplate(h2, year, degreeType) {
    let result = `<div class="mb-3 p-2 border-b-2 border-mode-gray">
                    <h2>${h2}</h2>
                    <div class="row justify-content-center">
                        <section class="col-6 p-2 px-4 text-start">
                            <h3>Primo Semestre</h3>
                            <ul class="list-style-none px-2 m-0">`;
    courses.forEach(corso => {
        if (corso.Year === year && corso.Semester === 1 && corso.Type === degreeType) {
        result += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
        }
    });
    result +=               `</ul>
                        </section>
                        <section class="col-6 p-2 px-4 text-start">
                            <h3>Secondo Semestre</h3>
                            <ul class="list-style-none px-2 m-0">`;
    courses.forEach(corso => {
        if (corso.Year === year && corso.Semester === 2 && corso.Type === degreeType) {
        result += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
        }
    });
    result +=               `</ul>
                        </section>
                    </div>
                </div>`;
    return result;
}

function updateDivCourses() {
    let divSmallMediaContainerContent = "";
    let divMediumMediaContainerContent = "";
    if (selectDegree.value === "0") {
        divSmallMediaContainerContent = smallMediaSectionTemplate("accordionPrimoAnno", "collapseOne", "Primo anno triennale", 1, "Laurea triennale");
        divSmallMediaContainerContent += smallMediaSectionTemplate("accordionSecondoAnno", "collapseTwo", "Secondo anno triennale", 2, "Laurea triennale");
        divSmallMediaContainerContent += smallMediaSectionTemplate("accordionTerzoAnno", "collapseThree", "Terzo anno triennale", 3, "Laurea triennale");
        divSmallMediaContainerContent += smallMediaSectionTemplate("accordionQuartoAnno", "collapseFour", "Primo anno magistrale", 1, "Laurea magistrale");
        divSmallMediaContainerContent += smallMediaSectionTemplate("accordionQuintoAnno", "collapseFive", "Secondo anno magistrale", 2, "Laurea magistrale");
        divSmallMediaContainer.innerHTML = divSmallMediaContainerContent;

        divMediumMediaContainerContent = mediumMediaSectionTemplate("Primo anno triennale", 1, "Laurea triennale");
        divMediumMediaContainerContent += mediumMediaSectionTemplate("Secondo anno triennale", 2, "Laurea triennale");
        divMediumMediaContainerContent += mediumMediaSectionTemplate("Terzo anno triennale", 3, "Laurea triennale");
        divMediumMediaContainerContent += mediumMediaSectionTemplate("Primo anno magistrale", 1, "Laurea magistrale");
        divMediumMediaContainerContent += mediumMediaSectionTemplate("Secondo anno magistrale", 2, "Laurea magistrale");
        divMediumMediaContainer.innerHTML = divMediumMediaContainerContent;
    }
    else {
        if (courses[0].Type === "Laurea triennale") {
            divSmallMediaContainerContent = smallMediaSectionTemplate("accordionPrimoAnno", "collapseOne", "Primo anno", 1, "Laurea triennale");
            divSmallMediaContainerContent += smallMediaSectionTemplate("accordionSecondoAnno", "collapseTwo", "Secondo anno", 2, "Laurea triennale");
            divSmallMediaContainerContent += smallMediaSectionTemplate("accordionTerzoAnno", "collapseThree", "Terzo anno", 3, "Laurea triennale");
            divSmallMediaContainer.innerHTML = divSmallMediaContainerContent;

            divMediumMediaContainerContent = mediumMediaSectionTemplate("Primo anno", 1, "Laurea triennale");
            divMediumMediaContainerContent += mediumMediaSectionTemplate("Secondo anno", 2, "Laurea triennale");
            divMediumMediaContainerContent += mediumMediaSectionTemplate("Terzo anno", 3, "Laurea triennale");
            divMediumMediaContainer.innerHTML = divMediumMediaContainerContent;
        }
        else if (courses[0].Type === "Laurea magistrale") {
            divSmallMediaContainerContent = smallMediaSectionTemplate("accordionQuartoAnno", "collapseFour", "Primo anno", 1, "Laurea magistrale");
            divSmallMediaContainerContent += smallMediaSectionTemplate("accordionQuintoAnno", "collapseFive", "Secondo anno", 2, "Laurea magistrale");
            divSmallMediaContainer.innerHTML = divSmallMediaContainerContent;

            divMediumMediaContainerContent = mediumMediaSectionTemplate("Primo anno", 1, "Laurea magistrale");
            divMediumMediaContainerContent += mediumMediaSectionTemplate("Secondo anno", 2, "Laurea magistrale");
            divMediumMediaContainer.innerHTML = divMediumMediaContainerContent;
        }
    }
}