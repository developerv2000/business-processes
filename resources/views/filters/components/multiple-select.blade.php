<x-form.group label="{{ __($label) }}">
    <select class="selectize-multiple @isset(request()->{$requestAttribute}) selectize-multiple--highlight @endisset" name="{{ $attribute }}" multiple>
        @foreach ($options as $option)
            <option value="{{ $option->id }}" @selected(request()->{$requestAttribute} &&  in_array($option->id, request()->{$requestAttribute}))>{{ $option->{$optionsCaptionAttribute} }}</option>
        @endforeach
    </select>
</x-form.group>
