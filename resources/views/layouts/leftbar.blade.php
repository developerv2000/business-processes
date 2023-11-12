<aside class="leftbar">
    <div class="leftbar__inner">
        <nav class="navbar">
            <x-navbar.title class="navbar__title--first">{{ __('Main') }}</x-navbar.title>

            <x-navbar.link icon="view_list" href="{{ route('manufacturers.index') }}" @class([
                'navbar-link--active' =>
                    request()->routeIs('manufacturers.*') ||
                    request()->routeIs('comments.manufacturer'),
            ])>{{ __('EPP') }}</x-navbar.link>

            <x-navbar.link icon="pill" href="{{ route('generics.index') }}" @class([
                'navbar-link--active' =>
                    request()->routeIs('generics.*') ||
                    request()->routeIs('comments.generic'),
            ])>{{ __('IVP') }}</x-navbar.link>

            <x-navbar.link icon="calendar_month" href="{{ route('meetings.index') }}" @class(['navbar-link--active' => request()->routeIs('meetings.*')])>
                {{ __('Meetings') }}
            </x-navbar.link>

            @if (request()->user()->isAdminOrModerator())
                <x-navbar.title>{{ __('Dashboard') }}</x-navbar.title>

                <x-navbar.link icon="prescriptions" href="{{ route('mnns.index') }}" @class(['navbar-link--active' => request()->routeIs('mnns.*')])>
                    {{ __('MNN') }}
                </x-navbar.link>

                @if (request()->user()->isAdmin())
                    <x-navbar.link icon="account_circle" href="{{ route('users.index') }}" @class(['navbar-link--active' => request()->routeIs('users.*')])>
                        {{ __('Users') }}
                    </x-navbar.link>
                @endif
            @endif
        </nav>
    </div>
</aside>
