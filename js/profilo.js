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