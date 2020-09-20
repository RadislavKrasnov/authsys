function showHeaderMenuDropdown() {
    document.getElementById("header-menu-dropdown").classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropdown-button')) {
        var dropdowns = document.getElementsByClassName("dropdown-items");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function logout() {
    $.post('/auth/account/logout').done(function () {
        window.location.href = '/';
    });
}
