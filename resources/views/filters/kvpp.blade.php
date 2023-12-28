<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('kvpp.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')

            @include('filters.components.pagination-limit')

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
