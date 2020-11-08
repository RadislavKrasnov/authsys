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

$(document).ready(function () {
    $('#user-info-section').on('click', function (event) {
        if (event.target.id !== 'user-info-section') {
            return;
        }

        var popup = $('#background-photo-popup');
        var topPosition = event.pageY;
        var leftPosition = event.pageX;
        var popupWidth = popup.outerWidth();
        var popupHeight = popup.outerHeight();
        var sectionWidth = $(this).outerWidth();
        var sectionHeight = $(this).outerHeight();

        if (popupHeight + topPosition > sectionHeight) {
            topPosition = sectionHeight - popupHeight;
        }

        if (leftPosition + popupWidth > sectionWidth) {
            leftPosition = leftPosition - popupWidth;
        }

        if (popup.css('display') !== 'none') {
            popup.hide();
        } else {
            popup.css({'top': topPosition});
            popup.css({'left': leftPosition});
            popup.show();
        }
    });
});
