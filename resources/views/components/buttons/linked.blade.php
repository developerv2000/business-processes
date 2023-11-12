@props(['href', 'style' => 'main', 'icon' => null, 'target' => '_self'])

<a class="button button--{{ $style }} {{ $attributes['class'] }}" href="{{ $href }}">
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</a>
