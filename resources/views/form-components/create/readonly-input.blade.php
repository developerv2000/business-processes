@props(['type' => 'text'])

<x-form.group label="{{ __($label) }}" required="0">
    <input class="input" type="{{ $type }}" value="{{ $value }}" readonly>
</x-form.group>
