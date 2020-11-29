<header>
    <div class="header-menu" onclick="showHeaderMenuDropdown()">
        <div class="header-avatar">
            <img src="<?= $imageOptimizer->resizeImage($avatarPath, 52, 52) ?>"
                 alt="<?= $user->firstName . ' ' . $user->lastName ?> avatar" />
        </div>
        <button class="dropdown-button">
            <?= $user->firstName . ' ' . $user->lastName ?>
        </button>
        <span class="arrow-down"></span>
        <div id="header-menu-dropdown" class="dropdown-items">
            <a href="/index">Home page</a>
            <a href="/auth/account/settings">Settings</a>
            <a onclick="logout()">Sign out</a>
        </div>
    </div>
    <div id="mobile-links">
        <a href="/index">Home page</a>
        <a href="/auth/account/settings">Settings</a>
        <a onclick="logout()">Sign out</a>
    </div>
    <div id="mobile-burger-icon" onclick="showBurgerMenu(this)">
        <div class="bar-one"></div>
        <div class="bar-two"></div>
        <div class="bar-three"></div>
    </div>
</header>
