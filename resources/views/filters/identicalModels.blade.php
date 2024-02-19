<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => url()->current()])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.belongs-to-select', [
                'label' => 'Name',
                'attribute' => 'id',
                'options' => $allItems,
                'optionsCaptionAttribute' => 'name',
            ])

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
