<div class="nested-container styled-box">
    <ol class="nested">
        @foreach ($items as $item)
            <li class="nested__item" id="menuItem_{{ $item->id }}">
                <div class="nested__item-body">
                    <span class="nested__item-toggler material-symbols-outlined">expand_less</span>
                    <span class="nested__item-title">{{ $item->name }}</span>
                    <span class="nested__item-destroy-btn material-symbols-outlined">close</span>
                </div>

                @if (count($item->children))
                    <ol class="nested__childs-list">
                        @include('nestedset.child', ['children' => $item->children])
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
</div>
