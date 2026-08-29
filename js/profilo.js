let currentTheme = localStorage.getItem("user-theme");
if (!currentTheme) {
    currentTheme = "primary";
}

const activeRadio = document.querySelector(`input[name="theme"][value="${currentTheme}"]`);
if (activeRadio) {
    activeRadio.checked = true;
}

const themeRadios = document.querySelectorAll('input[name="theme"]');

themeRadios.forEach(radio => {
    radio.addEventListener("change", (event) => {
        localStorage.setItem("user-theme", event.target.value);
        document.documentElement.setAttribute("data-theme", event.target.value);
    });
});

const applyButton = document.getElementById("applica-personalizza-tema");
const mainColorInput = document.getElementById("custom-main-color");
const whiteColorInput = document.getElementById("custom-white-color");
const bgLightColorInput = document.getElementById("custom-bg-light-color");
const textLightColorInput = document.getElementById("custom-text-light-color");
const bgDarkColorInput = document.getElementById("custom-bg-dark-color");
const textDarkColorInput = document.getElementById("custom-text-dark-color");

function setColors() {
    localStorage.setItem("custom-main-color", mainColorInput.value);
    localStorage.setItem("custom-white-color", whiteColorInput.value);
    localStorage.setItem("custom-bg-light-color", bgLightColorInput.value);
    localStorage.setItem("custom-text-light-color", textLightColorInput.value);
    localStorage.setItem("custom-bg-dark-color", bgDarkColorInput.value);
    localStorage.setItem("custom-text-dark-color", textDarkColorInput.value);
}

function setProperties() {
    document.documentElement.style.setProperty("--custom-main", mainColorInput.value);
    document.documentElement.style.setProperty("--custom-main-rgb", formatHexToRGB(mainColorInput.value));
    document.documentElement.style.setProperty("--custom-white", whiteColorInput.value);
    document.documentElement.style.setProperty("--custom-white-rgb", formatHexToRGB(whiteColorInput.value));
    document.documentElement.style.setProperty("--custom-bg-light", bgLightColorInput.value);
    document.documentElement.style.setProperty("--custom-bg-light-rgb", formatHexToRGB(bgLightColorInput.value));
    document.documentElement.style.setProperty("--custom-text-light", textLightColorInput.value);
    document.documentElement.style.setProperty("--custom-text-light-rgb", formatHexToRGB(textLightColorInput.value));
    document.documentElement.style.setProperty("--custom-bg-dark", bgDarkColorInput.value);
    document.documentElement.style.setProperty("--custom-text-dark", textDarkColorInput.value);
    document.documentElement.style.setProperty("--custom-text-dark-rgb", formatHexToRGB(textDarkColorInput.value));
}

applyButton.addEventListener("click", () => {
    setColors();
    setProperties();
});

