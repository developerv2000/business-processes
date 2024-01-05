<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('processes.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')

            @include('filters.components.date-input', [
                'label' => 'Date',
                'attribute' => 'date',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Search country',
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Manufacturer',
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Product STATUS',
                'attribute' => 'status_id',
                'options' => $statuses,
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
                'options' => $productForms,
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

            @include('filters.components.belongs-to-select', [
                'label' => 'Analyst',
                'attribute' => 'analyst_user_id',
                'options' => $analystUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'BDM',
                'attribute' => 'bdm_user_id',
                'options' => $bdmUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Responsible',
                'attribute' => 'owners[]',
                'requestAttribute' => 'owners',
                'options' => $owners,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Country of Manufacturer',
                'attribute' => 'country_id',
                'options' => $countries,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'MAH',
                'attribute' => 'promo_company_id',
                'options' => $promoCompanies,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Product category',
                'attribute' => 'generic_category_id',
                'options' => $productCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Category',
                'attribute' => 'manufacturer_category_id',
                'options' => $manufacturerCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.date-range-input', [
                'label' => 'Date of creation',
                'attribute' => 'created_at',
            ])

            @include('filters.components.date-range-input', [
                'label' => 'Update Date',
                'attribute' => 'updated_at',
            ])

            @include('filters.components.text-input', [
                // used because of KVPP table links to Processes table
                'label' => 'ID',
                'attribute' => 'id',
            ])

            @include('filters.components.pagination-limit')

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
