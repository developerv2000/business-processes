<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('kvpp.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')

            @include('filters.components.belongs-to-select', [
                'label' => 'Country',
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Priority',
                'attribute' => 'priority_id',
                'options' => $priorities,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Source',
                'attribute' => 'source_id',
                'options' => $sources,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Generic',
                'attribute' => 'mnn_id',
                'options' => $mnns,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Form',
                'attribute' => 'form_id',
                'options' => $forms,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.text-input', [
                'label' => 'Dosage',
                'attribute' => 'dose',
            ])

            @include('filters.components.text-input', [
                'label' => 'Pack',
                'attribute' => 'pack',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'MAH',
                'attribute' => 'promoCompanies[]',
                'requestAttribute' => 'promoCompanies',
                'options' => $promoCompanies,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Portfolio manager',
                'attribute' => 'portfolio_manager_id',
                'options' => $portfolioManagers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Analyst',
                'attribute' => 'analyst_user_id',
                'options' => $analystUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.date-range-input', [
                'label' => 'Date of creation',
                'attribute' => 'created_at',
            ])

            @include('filters.components.date-range-input', [
                'label' => 'Update date',
                'attribute' => 'updated_at',
            ])

            @include('filters.components.pagination-limit')

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
