<x-form.group-validateable label="{{ __($label) }}" error-name="{{ $attribute }}" required="{{ $required }}">
    <select class="selectize-singular" name="{{ $attribute }}" @required($required) @unless($required) placeholder="{{ __('Not selected') }}" @endunless>
        @unless ($required)
            <option></option>
        @endunless

        @foreach ($options as $option)
            <option value="{{ $option }}" @selected(old($attribute) == $option)>{{ $option }}</option>
        @endforeach
    </select>
</x-form.group-validateable>
