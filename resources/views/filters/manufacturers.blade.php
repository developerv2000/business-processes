<aside class="rightbar styled-box thin-scrollbar">
    <div class="filter">
        @include('filters.components.title', ['resetUrl' => route('manufacturers.index')])

        <form class="form filter-form" action="{{ $action }}" method="GET">
            @include('filters.components.hidden-default-orders')

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
                'label' => 'Country',
                'attribute' => 'country_id',
                'options' => $countries,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.text-input', [
                'label' => 'Manufacturer',
                'attribute' => 'name',
            ])

            @include('filters.components.belongs-to-select', [
                'label' => 'Category',
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])

            <x-form.group label="{{ __('Status') }}">
                <select class="selectize-singular @isset(request()->active) selectize-singular--highlight @endisset" name="active" placeholder="{{ __('Not selected') }}">
                    <option></option>
                    <option value="0" @selected(isset(request()->active) && request()->active == 0)>{{ __('Stoped') }}</option>
                    <option value="1" @selected(request()->active == 1)>{{ __('Active') }}</option>
                </select>
            </x-form.group>

            @include('filters.components.multiple-select', [
                'label' => 'Product category',
                'attribute' => 'productCategories[]',
                'requestAttribute' => 'productCategories',
                'options' => $productCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.date-input', [
                'label' => 'Date of creation',
                'attribute' => 'created_at',
            ])

            @include('filters.components.date-input', [
                'label' => 'Update Date',
                'attribute' => 'updated_at',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Zones',
                'attribute' => 'zones[]',
                'requestAttribute' => 'zones',
                'options' => $zones,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.boolean-belongs-to-select', [
                'label' => 'Important',
                'attribute' => 'important',
            ])

            @include('filters.components.multiple-select', [
                'label' => 'Black list',
                'attribute' => 'blacklists[]',
                'requestAttribute' => 'blacklists',
                'options' => $blacklists,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('filters.components.pagination-limit')

            <x-form.submit class="fiter-form__submit">{{ __('Update') }}</x-form.submit>
        </form>
    </div>
</aside>
