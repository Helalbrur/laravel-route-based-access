function applyTheme(themeId) {
    switch (themeId) {
        case "light-mode-switch":
            document.documentElement.removeAttribute("dir");
            document.getElementById("bootstrap-style").href = window.ASSET_BASE_URL + "skote/assets/css/bootstrap.min.css";
            document.getElementById("app-style").href = window.ASSET_BASE_URL + "skote/assets/css/app.min.css";
            document.documentElement.setAttribute("data-bs-theme", "light");
            break;
        case "dark-mode-switch":
            document.documentElement.removeAttribute("dir");
            document.getElementById("bootstrap-style").href = window.ASSET_BASE_URL + "skote/assets/css/bootstrap.min.css";
            document.getElementById("app-style").href = window.ASSET_BASE_URL + "skote/assets/css/app.min.css";
            document.documentElement.setAttribute("data-bs-theme", "dark");
            break;
        case "rtl-mode-switch":
            document.getElementById("bootstrap-style").href = window.ASSET_BASE_URL + "skote/assets/css/bootstrap.min.rtl.css";
            document.getElementById("app-style").href = window.ASSET_BASE_URL + "skote/assets/css/app.min.rtl.css";
            document.documentElement.setAttribute("dir", "rtl");
            document.documentElement.setAttribute("data-bs-theme", "light");
            break;
        case "dark-rtl-mode-switch":
            document.getElementById("bootstrap-style").href = window.ASSET_BASE_URL + "skote/assets/css/bootstrap.min.rtl.css";
            document.getElementById("app-style").href = window.ASSET_BASE_URL + "skote/assets/css/app.min.rtl.css";
            document.documentElement.setAttribute("dir", "rtl");
            document.documentElement.setAttribute("data-bs-theme", "dark");
            break;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var themeChoices = document.querySelectorAll('.theme-choice');
    
    themeChoices.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                var checkboxId = this.id;
                sessionStorage.setItem("selected_theme", checkboxId);
                applyTheme(checkboxId);
            }
        });
    });
    
    // Load saved theme
    if (window.sessionStorage) {
        var savedTheme = sessionStorage.getItem("selected_theme");
        if (savedTheme) {
            document.getElementById(savedTheme).checked = true;
            applyTheme(savedTheme);
        }
    }
});