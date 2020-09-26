function showBurgerMenu(burgerIcon) {
    burgerIcon.classList.toggle("change");

    var mobileLinks = document.getElementById("mobile-links");
    if (mobileLinks.style.display === "block") {
        mobileLinks.style.display = "none";
    } else {
        mobileLinks.style.display = "block";
    }
}

window.onload = function() {
    var mobileLinks = document.getElementById('mobile-links');
    var burgerIcon = document.getElementById('mobile-burger-icon');

    document.onclick = function(element) {

        if (element.target.parentElement.id !== 'mobile-burger-icon' &&
            element.target.id !== 'mobile-burger-icon' &&
            element.target.id !== 'mobile-links' &&
            mobileLinks.style.display !== 'none') {
            mobileLinks.style.display = 'none';
        }

        if (mobileLinks.style.display === 'none' && burgerIcon.classList) {
            burgerIcon.classList.remove('change');
        }
    };
};
