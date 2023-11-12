<x-form.group-validateable label="{{ __($label) }}" error-name="{{ $attribute }}" required="{{ $required }}">
    <input class="input" type="file" accept="{{ $accept }}" name="{{ $attribute }}" @required($required)>
</x-form.group-validateable>
