<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('processes.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')
            @include('filters.components.pagination-limit')

            @include('filters.components.date-input', [
                'label' => 'Date',
                'attribute' => 'date',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Country',
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
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
                'label' => 'Status',
                'attribute' => 'status_id',
                'options' => $statuses,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Owners',
                'attribute' => 'owners[]',
                'requestAttribute' => 'owners',
                'options' => $owners,
                'optionsCaptionAttribute' => 'name',
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
                'label' => 'Prod/categ',
                'attribute' => 'category_id',
                'options' => $categories,
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

            @include('filters.components.text-input', [
                'label' => 'ID',
                'attribute' => 'id',
            ])

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
