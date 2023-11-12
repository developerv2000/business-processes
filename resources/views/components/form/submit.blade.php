@props(['style' => 'main', 'icon' => null, 'form' => null, 'name' => null, 'value' => null])

<button class="button button--{{ $style }} {{ $attributes['class'] }}" type="submit" @if($form) form="{{ $form }}" @endif>
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</button>
