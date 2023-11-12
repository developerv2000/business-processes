<x-form.group-validateable label="{{ __('Current password') }}" error-name="current_password" required="{{ $required }}">
    <input class="input" type="password" name="current_password" autocomplete="current-password" minlength="4" @required($required)>
</x-form.group-validateable>
