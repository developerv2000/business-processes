<x-form.group-validateable label="{{ __($label) }}" error-name="{{ $attribute }}" required="{{ $required }}">
    <input class="input" type="number" step="{{ $step }}" name="{{ $attribute }}" @required($required) value="{{ old($attribute) }}">
</x-form.group-validateable>
