<x-form.group label="{{ __($label) }}">
    <select class="selectize-singular @isset(request()->{$attribute}) selectize-singular--highlight @endisset" name="{{ $attribute }}" placeholder="{{ __('Not selected') }}">
        <option></option>
        <option value="0" @selected(isset(request()->{$attribute}) && request()->{$attribute} == 0)>{{ __('No') }}</option>
        <option value="1" @selected(request()->{$attribute} == 1)>{{ __('Yes') }}</option>
    </select>
</x-form.group>
