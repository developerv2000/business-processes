@props(['image', 'name' => null, 'desc' => null])

<div class="ava {{ $attributes['class'] }}">
    <img class="ava__image" src="{{ asset('img/users/' . $image) }}">

    @if ($name || $desc)
        <div class="ava__text">
            <span class="ava__name">{{ $name }}</span>
            <span class="ava__desc">{{ $desc }}</span>
        </div>
    @endif
</div>
