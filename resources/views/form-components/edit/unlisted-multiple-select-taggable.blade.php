<x-form.group label="{{ __($label) }}" required="{{ $required }}">
    <select class="selectize-multiple--taggable" name="{{ $attribute }}" @required($required) multiple>
        @foreach ($item->{$relationName} as $option)
            <option value="{{ $option->{$optionsCaptionAttribute} }}" selected>{{ $option->{$optionsCaptionAttribute} }}</option>
        @endforeach
    </select>
</x-form.group>
