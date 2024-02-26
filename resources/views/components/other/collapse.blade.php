@props(['title', 'content'])

<div class="collapse {{ $attributes['class'] }}">
    <button class="collapse__header">
        <span class="collapse__header-title">{{ $title }}</span>
        <span class="collapse__header-icon material-symbols-outlined">expand_more</span>
    </button>

    <div class="collapse__content">
        {{ $slot }}
    </div>
</div>
