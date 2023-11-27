<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('generics.index')])

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
                'label' => 'Manufacturer',
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
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
                'label' => 'Dose',
                'attribute' => 'dose',
            ])

            @include('filters.components.text-input', [
                'label' => 'Pack',
                'attribute' => 'pack',
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
                'label' => 'Category',
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.text-input', [
                'label' => 'Brand',
                'attribute' => 'brand',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Expiration date',
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

            @include('filters.components.boolean-belongs-to-select', [
                'label' => 'Registered in EU',
                'attribute' => 'registered_in_eu',
            ])

            @include('filters.components.boolean-belongs-to-select', [
                'label' => 'Marketed in EU',
                'attribute' => 'marketed_in_eu',
            ])

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
