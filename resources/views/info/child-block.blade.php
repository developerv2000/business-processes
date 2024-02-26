@foreach ($children as $child)
    <div class="info-show__block-child">
        {{-- Collapse --}}
        @if ($child->is_collapse)
            <x-other.collapse title="{{ $child->name }}">
                {!! $child->content !!}

                @if (count($child->children))
                    @include('info.child-block', ['children' => $child->children])
                @endif
            </x-other.collapse>
        {{-- Non collapse --}}
        @else
            {!! $child->content !!}

            @if (count($child->children))
                @include('info.child-block', ['children' => $child->children])
            @endif
        @endif
    </div>
@endforeach
