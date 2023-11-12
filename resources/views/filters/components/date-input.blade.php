<x-form.group label="{{ __($label) }}">
    <input class="input @isset(request()->{$attribute}) input--highlight @endisset" type="date" name="{{ $attribute }}" value="{{ request()->{$attribute} }}">
</x-form.group>
