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

function updateColorInputs() {
    const mainColor = localStorage.getItem("custom-main-color");
    const whiteColor = localStorage.getItem("custom-white-color");
    const bgLightColor = localStorage.getItem("custom-bg-light-color");
    const textLightColor = localStorage.getItem("custom-text-light-color");
    const bgDarkColor = localStorage.getItem("custom-bg-dark-color");
    const textDarkColor = localStorage.getItem("custom-text-dark-color");

    if (mainColor && whiteColor && bgLightColor && textLightColor && bgDarkColor && textDarkColor) {
        mainColorInput.value = mainColor;
        whiteColorInput.value = whiteColor;
        bgLightColorInput.value = bgLightColor;
        textLightColorInput.value = textLightColor;
        bgDarkColorInput.value = bgDarkColor;
        textDarkColorInput.value = textDarkColor;
    }
}

updateColorInputs();

// Calcolo del contrasto, come indicato dalle regole WCAG: https://www.w3.org/WAI/WCAG21/Techniques/general/G18.html#procedure

function getLinearLuminance(c) {
    const sRGB = c / 255;
    return sRGB <= 0.03928
        ? sRGB / 12.92
        : Math.pow((sRGB + 0.055) / 1.055, 2.4);
}

function getRelativeLuminance(hex) {
    const cleanHex = hex.replace(/^#/, '');
    const rgb = parseInt(cleanHex, 16);
    const r = (rgb >> 16) & 0xff;
    const g = (rgb >>  8) & 0xff;
    const b = (rgb >>  0) & 0xff;

    const rLin = getLinearLuminance(r);
    const gLin = getLinearLuminance(g);
    const bLin = getLinearLuminance(b);

    return 0.2126 * rLin + 0.7152 * gLin + 0.0722 * bLin;
}

function getRatio(bgColor, contentColor) {
    const lum1 = getRelativeLuminance(bgColor);
    const lum2 = getRelativeLuminance(contentColor);

    const L1 = Math.max(lum1, lum2);
    const L2 = Math.min(lum1, lum2);

    const ratio = (L1 + 0.05) / (L2 + 0.05);
    return `${ratio.toFixed(2)}`;
}

const principaleContrastoP = document.getElementById("contrasto-principale");
const temaChiaroContrastoP = document.getElementById("contrasto-tema-chiaro");
const temaScuroContrastoP = document.getElementById("contrasto-tema-scuro");

function updateContrasts() {
    const prefix = "Valore del contrasto: ";
    principaleContrastoP.innerHTML = prefix + getRatio(mainColorInput.value, whiteColorInput.value);
    temaChiaroContrastoP.innerHTML = prefix + getRatio(bgLightColorInput.value, textLightColorInput.value);
    temaScuroContrastoP.innerHTML = prefix + getRatio(bgDarkColorInput.value, textDarkColorInput.value);
}

updateContrasts();

const colorInputs = document.querySelectorAll("div#custom-color-inputs-container input");

colorInputs.forEach(colorInput => {
    colorInput.addEventListener("change", updateContrasts);
});