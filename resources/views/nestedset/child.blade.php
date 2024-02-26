@foreach ($children as $child)
    <li class="nested__item" id="menuItem_{{ $child->id }}">
        <div class="nested__item-body">
            <span class="nested__item-toggler material-symbols-outlined">expand_less</span>
            <span class="nested__item-title">{{ $child->name }}</span>
            <span class="nested__item-destroy-btn material-symbols-outlined">close</span>
        </div>

        @if (count($child->children))
            <ol class="nested__childs-list">
                @include('nestedset.child', ['children' => $child->children])
            </ol>
        @endif
    </li>
@endforeach
