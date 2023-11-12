<div class="dropdown locales-dropdown">
    <x-buttons.localed class="dropdown__button" :value="app()->getLocale()">
        {{ app()->getLocale() }}
    </x-buttons.localed>

    <div class="dropdown__content">
        <form class="update-locale-form" action="{{ route('settings.update.locale') }}" method="POST">
            @csrf
            <x-buttons.localed value="en">English</x-buttons.localed>
            <x-buttons.localed value="ru">Русский</x-buttons.localed>
        </form>
    </div>
</div>
