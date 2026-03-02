const savedTheme = localStorage.getItem("user-theme");

if (savedTheme) {
    document.documentElement.setAttribute("data-theme", savedTheme);
}