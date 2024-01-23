@if ($processStage > 1) {{-- Used to hide empty parent --}}
    <div class="processes-edit__stage-inputs form">
        {{-- Stage 2 (ПО) --}}
        @if ($processStage > 1)
            <div class="form__divider">
                <x-form.group label="{{ __('Shelf life') }}" required="1">
                    <select class="selectize-singular" name="expiration_date_id" required>
                        @foreach ($expirationDates as $date)
                            <option value="{{ $date->id }}" @selected($item->generic->expiration_date_id == $date->id)>{{ $date->name }}</option>
                        @endforeach
                    </select>
                </x-form.group>

                <x-form.group-validateable label="{{ __('MOQ') }}" error-name="minimum_volume" required="1">
                    <input class="input" type="text" name="minimum_volume" value="{{ $item->generic->minimum_volume }}" required>
                </x-form.group-validateable>
            </div>

            <div class="form__divider">
                @include('form-components.edit.text-input', [
                    'label' => 'Forecast 1 year',
                    'type' => 'number',
                    'required' => true,
                    'attribute' => 'year_1',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Forecast 2 year',
                    'type' => 'number',
                    'required' => true,
                    'attribute' => 'year_2',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Forecast 3 year',
                    'type' => 'number',
                    'required' => true,
                    'attribute' => 'year_3',
                ])
            </div>
        @endif

        {{-- Stage 3 (АЦ) --}}
        @if ($processStage > 2)
            <div class="form__divider">
                @unless ($item->manufacturer_first_offered_price)
                    @include('form-components.edit.float-input', [
                        'label' => 'Manufacturer price 1',
                        'defaultValue' => 0.0,
                        'step' => 0.01,
                        'required' => true,
                        'attribute' => 'manufacturer_first_offered_price',
                    ])
                @endunless

                @include('form-components.edit.float-input', [
                    'label' => 'Manufacturer price 2',
                    'defaultValue' => 0.0,
                    'step' => 0.01,
                    'required' => true,
                    'attribute' => 'manufacturer_followed_offered_price',
                ])

                @include('form-components.edit.belongs-to-select', [
                    'label' => 'Currency',
                    'required' => true,
                    'attribute' => 'currency_id',
                    'options' => $currencies,
                    'optionsCaptionAttribute' => 'name',
                ])

                @unless ($item->our_first_offered_price)
                    @include('form-components.edit.float-input', [
                        'label' => 'Our price 1',
                        'defaultValue' => 0.0,
                        'step' => 0.01,
                        'required' => true,
                        'attribute' => 'our_first_offered_price',
                    ])
                @endunless

                @include('form-components.edit.float-input', [
                    'label' => 'Our price 2',
                    'defaultValue' => 0.0,
                    'step' => 0.01,
                    'required' => true,
                    'attribute' => 'our_followed_offered_price',
                ])
            </div>
        @endif

        {{-- Stage 4 (СЦ) --}}
        @if ($processStage > 3)
            <div class="form__divider">
                @include('form-components.edit.float-input', [
                    'label' => 'Agreed',
                    'defaultValue' => 0.0,
                    'step' => 0.01,
                    'required' => true,
                    'attribute' => 'agreed_price',
                ])
            </div>
        @endif

        {{-- Stage 5 (КК) --}}
        @if ($processStage > 4)
            <div class="form__divider">
                @include('form-components.edit.belongs-to-select', [
                    'label' => 'MAH',
                    'required' => true,
                    'attribute' => 'promo_company_id',
                    'options' => $promoCompanies,
                    'optionsCaptionAttribute' => 'name',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Brand Eng',
                    'required' => true,
                    'attribute' => 'trademark_en',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Brand Rus',
                    'required' => true,
                    'attribute' => 'trademark_ru',
                ])
            </div>
        @endif

        {{-- Additional Fields after Stage 4 (СЦ) --}}
        @if ($processStage > 3)
            <div class="form__divider">
                @include('form-components.edit.float-input', [
                    'label' => 'Price increased new price',
                    'defaultValue' => null,
                    'step' => 0.01,
                    'required' => false,
                    'attribute' => 'increased_price',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Dossier status',
                    'required' => false,
                    'attribute' => 'dossier_status',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Year Cr/Be',
                    'required' => false,
                    'attribute' => 'clinical_trial_year',
                ])

                @include('form-components.edit.multiple-select', [
                    'label' => 'Countries Cr/Be',
                    'required' => false,
                    'attribute' => 'crbeCountries[]',
                    'relationName' => 'crbeCountries',
                    'options' => $countries,
                    'optionsCaptionAttribute' => 'name',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Country ich',
                    'required' => false,
                    'attribute' => 'clinical_trial_ich_country',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Down payment 1',
                    'required' => false,
                    'attribute' => 'additional_1',
                ])

                @include('form-components.edit.text-input', [
                    'label' => 'Down payment 2',
                    'required' => false,
                    'attribute' => 'additional_2',
                ])
            </div>
        @endif
    </div>
@endif
