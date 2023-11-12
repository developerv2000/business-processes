<x-form.group-validateable label="{{ __($label) }}" error-name="{{ $attribute }}" required="{{ $required }}">
    <select class="selectize-singular" name="{{ $attribute }}" @required($required) @unless($required) placeholder="{{ __('Not selected') }}" @endunless>
        @unless ($required)
            <option></option>
        @endunless

        @foreach ($options as $option)
            <option value="{{ $option->id }}" @selected(old($attribute) == $option->id)>{{ $option->{$optionsCaptionAttribute} }}</option>
        @endforeach
    </select>
</x-form.group-validateable>
