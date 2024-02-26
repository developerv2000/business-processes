<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('info.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')

            @include('filters.components.belongs-to-select', [
                'label' => 'Name',
                'attribute' => 'id',
                'options' => $blocks,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.pagination-limit')

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
