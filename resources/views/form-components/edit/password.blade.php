<x-form.group-validateable label="{{ __('New password') }}" error-name="new_password" required="{{ $required }}">
    <input class="input" type="password" name="new_password" minlength="4" @required($required)>
</x-form.group-validateable>
