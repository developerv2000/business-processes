@foreach ($children as $child)
    <div class="info-index__block-child">
        @if ($child->is_collapse)
            <x-other.collapse title="{{ $child->name }}">
                {!! $child->content !!}

                @if (count($child->children))
                    @include('info.child', ['children' => $child->children])
                @endif
            </x-other.collapse>
        @else
            {!! $child->content !!}
        @endif
    </div>
@endforeach
