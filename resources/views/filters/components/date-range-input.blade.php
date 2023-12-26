<x-form.group label="{{ __($label) }}">
    <input class="input date-range-input @isset(request()->{$attribute}) input--highlight @endisset" type="text" name="{{ $attribute }}" value="{{ request()->{$attribute} }}" autocomplete="off">
</x-form.group>
