@extends('layouts.app', ['class' => 'kvpp-create rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('IVP'), __('Add new element')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('kvpp.store') }}" method="POST" id="create-form">
        @csrf

        <div class="form__divider">
            @include('form-components.create.belongs-to-select', [
                'label' => 'Status',
                'required' => true,
                'attribute' => 'status_id',
                'options' => $statuses,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Country',
                'required' => true,
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Priority',
                'required' => true,
                'attribute' => 'priority_id',
                'options' => $priorities,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Source',
                'required' => true,
                'attribute' => 'source_id',
                'options' => $sources,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.belongs-to-select', [
                'label' => 'Generic',
                'required' => true,
                'attribute' => 'mnn_id',
                'options' => $mnns,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Form',
                'required' => true,
                'attribute' => 'form_id',
                'options' => $forms,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Dosage',
                'required' => false,
                'attribute' => 'dose',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Pack',
                'required' => false,
                'attribute' => 'pack',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.multiple-select', [
                'label' => 'MAH',
                'required' => true,
                'attribute' => 'promoCompanies[]',
                'options' => $promoCompanies,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Information',
                'required' => false,
                'attribute' => 'info',
            ])

            @include('form-components.create.textarea', [
                'label' => 'Comment',
                'required' => false,
                'attribute' => 'comment',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'type' => 'date',
                'label' => 'Date of forecast',
                'required' => false,
                'attribute' => 'date_of_forecast',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Forecast 1 year',
                'type' => 'number',
                'required' => false,
                'attribute' => 'forecast_year_1',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Forecast 2 year',
                'type' => 'number',
                'required' => false,
                'attribute' => 'forecast_year_2',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Forecast 3 year',
                'type' => 'number',
                'required' => false,
                'attribute' => 'forecast_year_3',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Portfolio manager',
                'required' => false,
                'attribute' => 'portfolio_manager_id',
                'options' => $portfolioManagers,
                'optionsCaptionAttribute' => 'name',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
