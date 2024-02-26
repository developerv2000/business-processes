<x-form.group-validateable label="{{ __($label) }}" error-name="{{ $attribute }}" required="{{ $required }}">
    <textarea class="simditor-textarea" name="{{ $attribute }}" @required($required) rows="5">{{ old($attribute) }}</textarea>
</x-form.group-validateable>
