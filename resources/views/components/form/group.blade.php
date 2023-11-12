@props(['label', 'required' => false])

<div class="form-group {{ $attributes['class'] }}">
    <label class="label">
        <div class="label__text">
            {{ $label }}@if($required)<x-form.required-span />@endif
        </div>

        <div class="form-group__input-container">{{ $slot }}</div>
    </label>
</div>
