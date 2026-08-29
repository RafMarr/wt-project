const savedTheme = localStorage.getItem("user-theme");

if (savedTheme) {
    if (savedTheme == "custom") {
        const mainColor = localStorage.getItem("custom-main-color");
        const whiteColor = localStorage.getItem("custom-white-color");
        const bgLightColor = localStorage.getItem("custom-bg-light-color");
        const textLightColor = localStorage.getItem("custom-text-light-color");
        const bgDarkColor = localStorage.getItem("custom-bg-dark-color");
        const textDarkColor = localStorage.getItem("custom-text-dark-color");

        if (mainColor && whiteColor && bgLightColor && textLightColor && bgDarkColor && textDarkColor) {
            document.documentElement.style.setProperty("--custom-main", mainColor);
            document.documentElement.style.setProperty("--custom-main-rgb", formatHexToRGB(mainColor));
            document.documentElement.style.setProperty("--custom-white", whiteColor);
            document.documentElement.style.setProperty("--custom-white-rgb", formatHexToRGB(whiteColor));
            document.documentElement.style.setProperty("--custom-bg-light", bgLightColor);
            document.documentElement.style.setProperty("--custom-bg-light-rgb", formatHexToRGB(bgLightColor));
            document.documentElement.style.setProperty("--custom-text-light", textLightColor);
            document.documentElement.style.setProperty("--custom-text-light-rgb", formatHexToRGB(textLightColor));
            document.documentElement.style.setProperty("--custom-bg-dark", bgDarkColor);
            document.documentElement.style.setProperty("--custom-text-dark", textDarkColor);
            document.documentElement.style.setProperty("--custom-text-dark-rgb", formatHexToRGB(textDarkColor));
        }
    }
    document.documentElement.setAttribute("data-theme", savedTheme);
}

function formatHexToRGB(hex) {
    let cleanHex = hex.replace(/^#/, '');

    //Gestione formato breve
    if (cleanHex.length === 3) {
        cleanHex = cleanHex.split('').map(char => char + char).join('');
    }

    const num = parseInt(cleanHex, 16);
    const r = (num >> 16) & 255;
    const g = (num >> 8) & 255;
    const b = num & 255;

    return `${r}, ${g}, ${b}`;
}