@props(['style' => 'main', 'icon' => null])

<button class="button button--{{ $style }} {{ $attributes['class'] }}" type="button" data-click-action="hide-active-modals">
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</button>
