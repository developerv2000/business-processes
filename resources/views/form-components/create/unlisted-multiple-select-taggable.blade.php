<x-form.group label="{{ __($label) }}" required="{{ $required }}">
    <select class="selectize-multiple--taggable" name="{{ $attribute }}" @required($required) multiple>
    </select>
</x-form.group>
