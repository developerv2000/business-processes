<x-form.group label="{{ __($label) }}">
    <input class="input @isset(request()->{$attribute}) input--highlight @endisset" type="text" name="{{ $attribute }}" value="{{ request()->{$attribute} }}">
</x-form.group>
