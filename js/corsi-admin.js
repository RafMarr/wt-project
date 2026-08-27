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

function updateDivCourses() {
    let divSmallMediaContainerContent = "";
    let divMediumMediaContainerContent = "";
    if (selectDegree.value === "0") {
        divSmallMediaContainerContent = `<div class="accordion mb-5 mx-auto" id="accordionPrimoAnno">
                                        <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Primo anno triennale
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#accordionPrimoAnno">
                                            <div class="accordion-body text-start mode-bg-text">
                                            <section class="pt-3">
                                                <h3>Primo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 1 && corso.Type === "Laurea triennale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            <section class="pt-3">
                                                <h3>Secondo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 2 && corso.Type === "Laurea triennale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion mb-5 mx-auto" id="accordionSecondoAnno">
                                        <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Secondo anno triennale
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSecondoAnno">
                                            <div class="accordion-body text-start mode-bg-text">
                                            <section class="pt-3">
                                                <h3>Primo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 1 && corso.Type === "Laurea triennale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            <section class="pt-3">
                                                <h3>Secondo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 2 && corso.Type === "Laurea triennale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            </div>
                                        </div>
                                        </div>
                                    </div>`;
        divSmallMediaContainerContent += `<div class="accordion mb-5 mx-auto" id="accordionTerzoAnno">
                                    <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Terzo anno triennale
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionTerzoAnno">
                                        <div class="accordion-body text-start mode-bg-text">
                                        <section class="pt-3">
                                            <h3>Primo Semestre</h3>
                                            <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 3 && corso.Semester === 1 && corso.Type === "Laurea triennale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                        </section>
                                        <section class="pt-3">
                                            <h3>Secondo Semestre</h3>
                                            <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 3 && corso.Semester === 2 && corso.Type === "Laurea triennale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                        </section>
                                        </div>
                                    </div>
                                    </div>
                                </div>`;
        divSmallMediaContainerContent += `<div class="accordion mb-5 mx-auto" id="accordionQuartoAnno">
                                        <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Primo anno magistrale
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionQuartoAnno">
                                            <div class="accordion-body text-start mode-bg-text">
                                            <section class="pt-3">
                                                <h3>Primo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 1 && corso.Type === "Laurea magistrale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            <section class="pt-3">
                                                <h3>Secondo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 2 && corso.Type === "Laurea magistrale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion mb-5 mx-auto" id="accordionQuintoAnno">
                                        <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            Secondo anno magistrale
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionQuintoAnno">
                                            <div class="accordion-body text-start mode-bg-text">
                                            <section class="pt-3">
                                                <h3>Primo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 1 && corso.Type === "Laurea magistrale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            <section class="pt-3">
                                                <h3>Secondo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 2 && corso.Type === "Laurea magistrale") {
            divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divSmallMediaContainerContent += `</ul>
                                            </section>
                                            </div>
                                        </div>
                                        </div>
                                    </div>`;
        divSmallMediaContainer.innerHTML = divSmallMediaContainerContent;

        divMediumMediaContainerContent = `<div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Primo anno triennale</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 1 && corso.Type === "Laurea triennale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 2 && corso.Type === "Laurea triennale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Secondo anno triennale</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 1 && corso.Type === "Laurea triennale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 2 && corso.Type === "Laurea triennale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>`;
        divMediumMediaContainerContent += `<div class="mb-3 p-2 border-b-2 border-mode-gray">
            <h2>Terzo anno triennale</h2>
            <div class="row justify-content-center">
                <section class="col-6 p-2 px-4 text-start">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 3 && corso.Semester === 1 && corso.Type === "Laurea triennale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                </section>
                <section class="col-6 p-2 px-4 text-start">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 3 && corso.Semester === 2 && corso.Type === "Laurea triennale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                </section>
            </div>
        </div>`;
        divMediumMediaContainerContent += `<div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Primo anno magistrale</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 1 && corso.Type === "Laurea magistrale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 1 && corso.Semester === 2 && corso.Type === "Laurea magistrale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Secondo anno magistrale</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 1 && corso.Type === "Laurea magistrale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
        courses.forEach(corso => {
            if (corso.Year === 2 && corso.Semester === 2 && corso.Type === "Laurea magistrale") {
            divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
            }
        });
        divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>`;
        divMediumMediaContainer.innerHTML = divMediumMediaContainerContent;
    }
    else {
        if (courses[0].Type === "Laurea triennale") {
            divSmallMediaContainerContent = `<div class="accordion mb-5 mx-auto" id="accordionPrimoAnno">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Primo anno
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#accordionPrimoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 1) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 2) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion mb-5 mx-auto" id="accordionSecondoAnno">
              <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Secondo anno
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSecondoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 1) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 2) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion mb-5 mx-auto" id="accordionTerzoAnno">
              <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Terzo anno
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionTerzoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
                courses.forEach(corso => {
                    if (corso.Year === 3 && corso.Semester === 1) {
                    divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                    }
                });
                divSmallMediaContainerContent += `</ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">`;
                courses.forEach(corso => {
                    if (corso.Year === 3 && corso.Semester === 2) {
                    divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                    }
                });
                divSmallMediaContainerContent += `</ul>
                  </section>
                </div>
              </div>
            </div>
          </div>`;
                divSmallMediaContainer.innerHTML = divSmallMediaContainerContent;

            divMediumMediaContainerContent = `<div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Primo anno</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 1) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 2) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Secondo anno</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 1) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 2) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>`;
            divMediumMediaContainerContent += `<div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Terzo anno</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 3 && corso.Semester === 1) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 3 && corso.Semester === 2) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                    </section>
                </div>
            </div>`;
            divMediumMediaContainer.innerHTML = divMediumMediaContainerContent;
        }
        else if (courses[0].Type === "Laurea magistrale") {
            divSmallMediaContainerContent += `<div class="accordion mb-5 mx-auto" id="accordionQuartoAnno">
                                        <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Primo anno
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionQuartoAnno">
                                            <div class="accordion-body text-start mode-bg-text">
                                            <section class="pt-3">
                                                <h3>Primo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 1) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                                            </section>
                                            <section class="pt-3">
                                                <h3>Secondo Semestre</h3>
                                                <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 2) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                                                </section>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="accordion mb-5 mx-auto" id="accordionQuintoAnno">
                                            <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                Secondo anno
                                                </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionQuintoAnno">
                                                <div class="accordion-body text-start mode-bg-text">
                                                <section class="pt-3">
                                                    <h3>Primo Semestre</h3>
                                                    <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 1) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                                                </section>
                                                <section class="pt-3">
                                                    <h3>Secondo Semestre</h3>
                                                    <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 2) {
                divSmallMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divSmallMediaContainerContent += `</ul>
                                                </section>
                                                </div>
                                            </div>
                                            </div>
                                        </div>`;
            divSmallMediaContainer.innerHTML = divSmallMediaContainerContent;

            divMediumMediaContainerContent += `<div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Primo anno</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 1) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                        </section>
                        <section class="col-6 p-2 px-4 text-start">
                            <h3>Secondo Semestre</h3>
                            <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 1 && corso.Semester === 2) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                        </section>
                    </div>
                </div>
                <div class="mb-3 p-2 border-b-2 border-mode-gray">
                    <h2>Secondo anno</h2>
                    <div class="row justify-content-center">
                        <section class="col-6 p-2 px-4 text-start">
                            <h3>Primo Semestre</h3>
                            <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 1) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                        </section>
                        <section class="col-6 p-2 px-4 text-start">
                            <h3>Secondo Semestre</h3>
                            <ul class="accordion-list px-2 m-0">`;
            courses.forEach(corso => {
                if (corso.Year === 2 && corso.Semester === 2) {
                divMediumMediaContainerContent += `<li class="my-2"><a class="mode-text" href="courses.php?courseID=${corso.CourseID}">${corso.CourseID} - ${corso.Name}</a></li>`;
                }
            });
            divMediumMediaContainerContent += `</ul>
                        </section>
                    </div>
                </div>`;
            divMediumMediaContainer.innerHTML = divMediumMediaContainerContent;
        }
    }
}