<div class="dropdown profile-dropdown">
    <div class="dropdown__button">
        <x-other.ava image="{{ request()->user()->photo }}"></x-other.ava>
    </div>

    <div class="dropdown__content">
        <x-navbar.link icon="face" href="{{ route('profile.edit') }}" @class(['navbar-link--active' => request()->routeIs('profile.edit')])>{{ __('My profile') }}</x-navbar.link>

        <form action="/logout" method="POST">
            @csrf
            <x-navbar.button icon="exit_to_app">{{ __('Logout') }}</x-navbar.button>
        </form>
    </div>
</div>
