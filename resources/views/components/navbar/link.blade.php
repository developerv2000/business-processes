@props(['href', 'icon', 'text'])

<a class="navbar-link {{ $attributes['class'] }}" href="{{ $href }}">
    <span class="material-symbols-outlined navbar-link__icon">{{ $icon }}</span>
    <span class="navbar-link__text">{{ $slot }}</span>
</a>
