@props(['modalTarget', 'style' => 'main', 'icon' => null])

<button class="button button--{{ $style }} {{ $attributes['class'] }}" type="button" data-click-action="show-modal" data-modal-target="{{ $modalTarget }}">
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</button>
