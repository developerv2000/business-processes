@props(['label', 'errorName', 'required' => false])

<div class="form-group @error($errorName) form-group--error @enderror">
    <label class="label">
        <div class="label__text">{{ $label }}@if($required)<x-form.required-span />@endif</div>

        <div class="form-group__input-container">
            {{ $slot }}
            <span class="material-symbols-outlined form-group__error-icon">error</span>
        </div>
    </label>

    <p class="form-group__error-message">@error($errorName) {{ $message }} @enderror</p>
</div>
