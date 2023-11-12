<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('manufacturers.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')
            @include('filters.components.pagination-limit')

            @include('filters.components.date-input', [
                'label' => 'Created at',
                'attribute' => 'created_at',
            ])

            @include('filters.components.date-input', [
                'label' => 'From created at date',
                'attribute' => 'created_from_date',
            ])

            @include('filters.components.date-input', [
                'label' => 'To created at date',
                'attribute' => 'created_to_date',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Category',
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.text-input', [
                'label' => 'Manufacturer',
                'attribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'BDM',
                'attribute' => 'bdm_user_id',
                'options' => $bdmUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Analyst',
                'attribute' => 'analyst_user_id',
                'options' => $analystUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Country',
                'attribute' => 'country_id',
                'options' => $countries,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.boolean-belongs-to-select', [
                'label' => 'Cooperates',
                'attribute' => 'cooperates',
            ])

            @include('filters.components.boolean-belongs-to-select', [
                'label' => 'Process',
                'attribute' => 'active',
            ])

            @include('filters.components.boolean-belongs-to-select', [
                'label' => 'Important',
                'attribute' => 'important',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Zones',
                'attribute' => 'zones[]',
                'requestAttribute' => 'zones',
                'options' => $zones,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Prod/categ',
                'attribute' => 'productCategories[]',
                'requestAttribute' => 'productCategories',
                'options' => $productCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Blacklist',
                'attribute' => 'blacklists[]',
                'requestAttribute' => 'blacklists',
                'options' => $blacklists,
                'optionsCaptionAttribute' => 'name',
            ])

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
