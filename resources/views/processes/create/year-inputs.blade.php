{{-- Year inputs are required only started from Stage 2 (ПО) --}}
@if ($processStage > 1 && count($selectedCountryCodes)) {{-- Used to hide empty parent --}}
    <div class="processes-create__year-inputs form">
        @foreach ($selectedCountryCodes as $country)
            <div class="form__divider">
                @include('form-components.create.text-input', [
                    'label' => 'Year 1 ' . $country->name,
                    'required' => true,
                    'attribute' => 'year_1_' . $country->name,
                ])

                @include('form-components.create.text-input', [
                    'label' => 'Year 2 ' . $country->name,
                    'required' => true,
                    'attribute' => 'year_2_' . $country->name,
                ])

                @include('form-components.create.text-input', [
                    'label' => 'Year 3 ' . $country->name,
                    'required' => true,
                    'attribute' => 'year_3_' . $country->name,
                ])
            </div>
        @endforeach
    </div>
@endif
