@extends('layouts.app', ['class' => 'kvpp-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('IVP'), __('Edit'), $item->brand ?? '# ' . $item->id],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('kvpp.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')

        <div class="form__divider">
            @include('form-components.edit.belongs-to-select', [
                'label' => 'Status',
                'required' => true,
                'attribute' => 'status_id',
                'options' => $statuses,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Country',
                'required' => true,
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Priority',
                'required' => true,
                'attribute' => 'priority_id',
                'options' => $priorities,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Source',
                'required' => true,
                'attribute' => 'source_id',
                'options' => $sources,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.belongs-to-select', [
                'label' => 'Generic',
                'required' => true,
                'attribute' => 'mnn_id',
                'options' => $mnns,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Form',
                'required' => true,
                'attribute' => 'form_id',
                'options' => $forms,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Dosage',
                'required' => true,
                'attribute' => 'dose',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Pack',
                'required' => true,
                'attribute' => 'pack',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.belongs-to-select', [
                'label' => 'MAH',
                'required' => true,
                'attribute' => 'promo_company_id',
                'options' => $promoCompanies,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Information',
                'required' => false,
                'attribute' => 'info',
            ])

            @if ($item->lastComment)
                @include('form-components.edit.readonly-textarea', [
                    'label' => 'Last comment',
                    'value' => $item->lastComment->body,
                ])
            @endif

            @include('form-components.edit.textarea', [
                'label' => 'Add new comment',
                'required' => false,
                'attribute' => 'comment',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'type' => 'date',
                'label' => 'Date of forecast',
                'required' => true,
                'attribute' => 'date_of_forecast',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Forecast 1 year',
                'type' => 'number',
                'required' => true,
                'attribute' => 'forecast_year_1',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Forecast 2 year',
                'type' => 'number',
                'required' => true,
                'attribute' => 'forecast_year_2',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Forecast 3 year',
                'type' => 'number',
                'required' => true,
                'attribute' => 'forecast_year_3',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Portfolio manager',
                'required' => true,
                'attribute' => 'portfolio_manager_id',
                'options' => $portfolioManagers,
                'optionsCaptionAttribute' => 'name',
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
