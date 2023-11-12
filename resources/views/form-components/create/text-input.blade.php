@props(['type' => 'text'])

<x-form.group-validateable label="{{ __($label) }}" error-name="{{ $attribute }}" required="{{ $required }}">
    <input class="input" type="{{ $type }}" name="{{ $attribute }}" @required($required) value="{{ old($attribute) }}">
</x-form.group-validateable>
