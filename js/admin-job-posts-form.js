const degreeCourseSelectContainer = document.querySelector('#degree-course-select-container')
const degreeCourseSelect = document.querySelector('#degree-course')
const degreeCourseChoiceYesRadioBtn = document.querySelector('#degree-course-choice-yes')
const degreeCourseChoiceNoRadioBtn = document.querySelector('#degree-course-choice-no')

degreeCourseChoiceYesRadioBtn.addEventListener('change', () => {
    degreeCourseSelect.setAttribute("required", "")
    degreeCourseSelectContainer.classList.remove("d-none")
})

degreeCourseChoiceNoRadioBtn.addEventListener('change', () => {
    degreeCourseSelect.removeAttribute("required")
    degreeCourseSelectContainer.classList.add("d-none")
})
