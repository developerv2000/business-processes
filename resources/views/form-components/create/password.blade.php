<x-form.group-validateable label="{{ __('Password') }}" error-name="password" required="{{ $required }}">
    <input class="input" type="password" name="password" minlength="4" @required($required)>
</x-form.group-validateable>
