<aside class="leftbar">
    <div class="leftbar__inner">
        <nav class="navbar">
            <x-navbar.title class="navbar__title--first">{{ __('Main') }}</x-navbar.title>

            <x-navbar.link icon="view_list" href="{{ route('manufacturers.index') }}" @class([
                'navbar-link--active' =>
                    request()->routeIs('manufacturers.*') ||
                    request()->routeIs('comments.manufacturer'),
            ])>{{ __('EPP') }}</x-navbar.link>

            <x-navbar.link icon="content_paste_search" href="{{ route('kvpp.index') }}" @class([
                'navbar-link--active' =>
                    request()->routeIs('kvpp.*') || request()->routeIs('comments.kvpp'),
            ])>{{ __('KVPP') }}</x-navbar.link>

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

            <x-navbar.link icon="calendar_month" href="{{ route('meetings.index') }}" @class(['navbar-link--active' => request()->routeIs('meetings.*')])>
                {{ __('Meetings') }}
            </x-navbar.link>

            <x-navbar.link icon="view_list" href="{{ route('kpe.index') }}" @class([
                'navbar-link--active' => request()->routeIs('kpe.index'),
            ])>{{ __('КПЭ') }}</x-navbar.link>

            <x-navbar.link icon="info" href="{{ route('info.show') }}" @class([
                'navbar-link--active' => request()->routeIs('info.show'),
            ])>{{ __('Info') }}</x-navbar.link>

            @if (request()->user()->isAdminOrModerator())
                <x-navbar.title>{{ __('Dashboard') }}</x-navbar.title>

                <x-navbar.link icon="dataset" href="{{ route('identical-models.list') }}" @class([
                    'navbar-link--active' => request()->routeIs('identical-models.*'),
                ])>
                    {{ __('Different') }}
                </x-navbar.link>

                <x-navbar.link icon="account_circle" href="{{ route('users.index') }}" @class(['navbar-link--active' => request()->routeIs('users.*')])>
                    {{ __('Users') }}
                </x-navbar.link>

                <x-navbar.link icon="info" href="{{ route('info.index') }}" @class([
                    'navbar-link--active' =>
                        request()->routeIs('info.*') && !request()->routeIs('info.show'),
                ])>
                    {{ __('Info') }}
                </x-navbar.link>
            @endif

            {{-- Temporary statistics --}}
            <x-navbar.title>{{ __('Статистика') }}</x-navbar.title>

            <div class="statistics">
                @foreach ($analysts as $analyst)
                    <p class="statistics__analyst-name">{{ $analyst->name }}</p>

                    <div class="statistics__links-container">
                        <a class="statistics__analyst-link" href="{{ $analyst->statistics_epp_link }}">{{ __('EPP') }} - {{ $analyst->created_epps }}</a>
                        <a class="statistics__analyst-link" href="{{ $analyst->statistics_ivp_link }}">{{ __('IVP') }} - {{ $analyst->created_ivps }}</a>
                        <a class="statistics__analyst-link" href="{{ $analyst->statistics_vps_link }}">{{ __('VPS') }} - {{ $analyst->created_vpses }}</a>
                        <a class="statistics__analyst-link" href="{{ $analyst->statistics_kvpp_link }}">{{ __('KVPP') }} - {{ $analyst->created_kvpps }}</a>
                        <a class="statistics__analyst-link">TOTAL - {{ $analyst->created_total }}</a>
                    </div>
                @endforeach
            </div>
        </nav>
    </div>
</aside>
