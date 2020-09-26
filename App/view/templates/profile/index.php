<header>
    <div class="header-menu" onclick="showHeaderMenuDropdown()">
        <div class="header-avatar">
            <img src="https://via.placeholder.com/150" alt="#" />
        </div>
        <button class="dropdown-button">John Smith</button>
        <span class="arrow-down"></span>
        <div id="header-menu-dropdown" class="dropdown-items">
            <a href="/auth/account/settings">Settings</a>
            <a onclick="logout()">Sign out</a>
        </div>
    </div>
    <div id="mobile-links">
        <a href="/auth/account/settings">Settings</a>
        <a onclick="logout()">Sign out</a>
    </div>
    <div id="mobile-burger-icon" onclick="showBurgerMenu(this)">
        <div class="bar-one"></div>
        <div class="bar-two"></div>
        <div class="bar-three"></div>
    </div>
</header>
<main>
    <section class="user-info-section"
             style="background-image: url('/media/profile/background/calanques-marseille-istock-johansjolander.jpg')">
        <div class="user-info-center">
            <div class="avatar">
                <img src="https://via.placeholder.com/200" alt="#" />
            </div>
            <div class="info">
                <span class="name">John Smith</span>
                <span class="location">Marseille, Provance-Alpes-Cote D'Azure, France</span>
            </div>
        </div>
    </section>
    <section class="content"></section>
</main>
<footer>
    <span>Authsys.local 2020</span>
</footer>
