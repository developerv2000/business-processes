<div class="radiogroup">
    <label class="label">
        <div class="label__text">
            {{ __($label) }}@if($required)<x-form.required-span />@endif
        </div>
    </label>

    <div class="radiogroup__options-container">{{ $slot }}</div>
</div>
