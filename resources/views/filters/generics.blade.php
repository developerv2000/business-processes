<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('generics.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')

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
                'label' => 'Country',
                'attribute' => 'country_id',
                'options' => $countries,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Manufacturer',
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Category',
                'attribute' => 'manufacturer_category_id',
                'options' => $manufacturerCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Product category',
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
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

            @include('filters.components.belongs-to-select', [
                'label' => 'Shelf Life',
                'attribute' => 'expiration_date_id',
                'options' => $expirationDates,
                'optionsCaptionAttribute' => 'limit',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Zones',
                'attribute' => 'zones[]',
                'requestAttribute' => 'zones',
                'options' => $zones,
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

            @include('filters.components.pagination-limit')

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
