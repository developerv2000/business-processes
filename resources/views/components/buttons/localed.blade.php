@props(['value'])

<button class="button button--localed {{ $attributes['class'] }}" name="locale" value="{{ $value }}">
    <img src="{{ asset('img/main/flag-' . $value . '.png') }}" alt="{{ $value }}">
    <span>{{ $slot }}</span>
</button>
