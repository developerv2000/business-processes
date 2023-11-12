<header class="header">
    <div class="header__inner main-container">
        <div class="header__left">
            <button class="aside-toggler">
                <span class="material-symbols-outlined">hide</span>
            </button>

            <x-other.logo class="header__logo" />
        </div>

        <div class="header__right">
            <x-dropdowns.locales />
            <span class="material-symbols-outlined header__notifications">notifications</span>
            <x-dropdowns.profile />
        </div>
    </div>
</header>
