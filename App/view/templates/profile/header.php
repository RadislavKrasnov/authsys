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
