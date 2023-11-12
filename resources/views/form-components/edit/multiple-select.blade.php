<x-form.group label="{{ __($label) }}" required="{{ $required }}">
    <select class="selectize-multiple" name="{{ $attribute }}" @required($required) multiple>
        @foreach ($options as $option)
            <option value="{{ $option->id }}" @selected($item->{$relationName}->contains('id', $option->id))>{{ $option->{$optionsCaptionAttribute} }}</option>
        @endforeach
    </select>
</x-form.group>
