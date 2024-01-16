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

            <x-navbar.link icon="stacks" href="{{ route('processes.index') }}" @class([
                'navbar-link--active' =>
                    request()->routeIs('processes.*') ||
                    request()->routeIs('comments.process'),
            ])>{{ __('VPS') }}</x-navbar.link>

            <x-navbar.link icon="content_paste_search" href="{{ route('kvpp.index') }}" @class([
                'navbar-link--active' =>
                    request()->routeIs('kvpp.*') || request()->routeIs('comments.kvpp'),
            ])>{{ __('KVPP') }}</x-navbar.link>

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

            {{-- Temporary statistics --}}
            @if (request()->user()->id == 1)
                <x-navbar.title>{{ __('Статистика') }}</x-navbar.title>

                <div class="statistics">
                    @foreach ($analysts as $analyst)
                        <p class="statistics__analyst-name">{{ $analyst->name }}</p>

                        <div class="statistics__links-container">
                            <a class="statistics__analyst-link" href="{{ $analyst->statistics_epp_link }}">{{ __('EPP') }} - {{ $analyst->today_created_epps }}</a>
                            <a class="statistics__analyst-link" href="{{ $analyst->statistics_ivp_link }}">{{ __('IVP') }} - {{ $analyst->today_created_ivps }}</a>
                            <a class="statistics__analyst-link" href="{{ $analyst->statistics_vps_link }}">{{ __('VPS') }} - {{ $analyst->today_created_vpses }}</a>
                            <a class="statistics__analyst-link">TOTAL - {{ $analyst->created_total }}</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </nav>
    </div>
</aside>
