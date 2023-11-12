<x-form.group label="{{ __($label) }}">
    <select class="selectize-singular @isset(request()->{$attribute}) selectize-singular--highlight @endisset" name="{{ $attribute }}" placeholder="{{ __('Not selected') }}">
        <option></option>

        @foreach ($options as $option)
            <option value="{{ $option->id }}" @selected(request()->{$attribute} == $option->id)>{{ $option->{$optionsCaptionAttribute} }}</option>
        @endforeach
    </select>
</x-form.group>
