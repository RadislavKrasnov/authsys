function showBurgerMenu(burgerIcon) {
    burgerIcon.classList.toggle("change");

    var mobileLinks = document.getElementById("mobile-links");
    if (mobileLinks.style.visibility === "visible") {
        mobileLinks.style.visibility = "hidden";
        mobileLinks.classList.remove('mobile-menu-sidebar');
    } else {
        mobileLinks.style.visibility = "visible";
        mobileLinks.classList.add('mobile-menu-sidebar');
    }
}

window.onload = function() {
    var mobileLinks = document.getElementById('mobile-links');
    var burgerIcon = document.getElementById('mobile-burger-icon');

    document.onclick = function(element) {

        if (element.target.parentElement.id !== 'mobile-burger-icon' &&
            element.target.id !== 'mobile-burger-icon' &&
            element.target.id !== 'mobile-links' &&
            mobileLinks.style.visibility !== 'hidden') {
            mobileLinks.style.visibility = 'hidden';
            mobileLinks.classList.remove('mobile-menu-sidebar');
        }

        if (mobileLinks.style.visibility === 'hidden' && burgerIcon.classList) {
            burgerIcon.classList.remove('change');
        }
    };
};
