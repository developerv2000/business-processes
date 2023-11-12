<x-form.radio-group label="{{ __($label) }}" required="{{ $required }}">
    @foreach ($options as $option)
        <label class="radiogroup__option">
            <input class="radio" type="radio" name="{{ $attribute }}" value="{{ $option['value'] }}" @required($required)>
            <div class="radiogroup__option-text">{{ $option['label'] }}</div>
        </label>
    @endforeach
</x-form.radio-group>
