<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('mnns.index')])

        <form class="form filter-form" action="{{ route('mnns.index') }}" method="GET">
            @include('filters.components.hidden-default-orders')
            @include('filters.components.pagination-limit')

            @include('filters.components.text-input', [
                'label' => 'Name',
                'attribute' => 'name',
            ])

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
