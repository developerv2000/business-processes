<div class="processes-create__additional-inputs form">
    {{-- Stage 2 (ПО) --}}
    @if ($processStage > 1)
        <div class="form__divider">
            <x-form.group label="{{ __('Expiration date') }}" required>
                <select class="selectize-singular" name="expiration_date_id" required>
                    @foreach ($expirationDates as $date)
                        <option value="{{ $date->id }}" @selected($generic->expiration_date_id == $date->id)>{{ $date->limit }}</option>
                    @endforeach
                </select>
            </x-form.group>

            <x-form.group-validateable label="{{ __('Minimum volume') }}" error-name="minimum_volume" required>
                <input class="input" type="text" name="minimum_volume" value="{{ old('minimum_volume', $generic->minimum_volume) }}" required>
            </x-form.group-validateable>

            @include('form-components.create.text-input', [
                'label' => 'Year 1',
                'required' => true,
                'attribute' => 'year_1',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Year 2',
                'required' => true,
                'attribute' => 'year_2',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Year 3',
                'required' => true,
                'attribute' => 'year_3',
            ])
        </div>
    @endif

    {{-- Stage 3 (АЦ) --}}
    @if ($processStage > 2)
        <div class="form__divider">
            @include('form-components.create.float-input', [
                'label' => 'Price 1',
                'step' => 0.01,
                'required' => true,
                'attribute' => 'manufacturer_first_offered_price',
            ])

            @include('form-components.create.float-input', [
                'label' => 'Price 2',
                'step' => 0.01,
                'required' => true,
                'attribute' => 'manufacturer_followed_offered_price',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Currency',
                'required' => true,
                'attribute' => 'currency_id',
                'options' => $currencies,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.float-input', [
                'label' => 'Our price 1',
                'step' => 0.01,
                'required' => true,
                'attribute' => 'our_first_offered_price',
            ])

            @include('form-components.create.float-input', [
                'label' => 'Our price 2',
                'step' => 0.01,
                'required' => true,
                'attribute' => 'our_followed_offered_price',
            ])
        </div>
    @endif

    {{-- Stage 4 (СЦ) --}}
    @if ($processStage > 3)
        <div class="form__divider">
            @include('form-components.create.float-input', [
                'label' => 'Agreed',
                'step' => 0.01,
                'required' => true,
                'attribute' => 'agreed',
            ])
        </div>
    @endif

    {{-- Stage 5 (КК) --}}
    @if ($processStage > 4)
        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'MAH',
                'required' => true,
                'attribute' => 'marketing_authorization_holder',
            ])

            @include('form-components.create.text-input', [
                'label' => 'TM ENG',
                'required' => true,
                'attribute' => 'trademark_en',
            ])

            @include('form-components.create.text-input', [
                'label' => 'TM RUS',
                'required' => true,
                'attribute' => 'trademark_ru',
            ])
        </div>
    @endif
</div>
