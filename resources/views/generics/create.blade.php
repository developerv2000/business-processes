@extends('layouts.app', ['class' => 'generics-create rightbarless'])

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

    <form class="form main-form create-form" action="{{ route('generics.store') }}" method="POST" id="create-form">
        @csrf

        <div class="form__divider">
            @include('form-components.create.belongs-to-select', [
                'label' => 'Manufacturer',
                'required' => true,
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
                'optionsCaptionAttribute' => 'name',
            ])

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
                'options' => $productForms,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider similar-products generics-similar-products"></div>

        <div class="form__divider">
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

            @include('form-components.create.text-input', [
                'label' => 'Manufacturer Brand',
                'required' => false,
                'attribute' => 'brand',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Product category',
                'required' => true,
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'MOQ',
                'required' => false,
                'attribute' => 'minimum_volume',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Shelf life',
                'required' => true,
                'attribute' => 'expiration_date_id',
                'options' => $expirationDates,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'Dossier',
                'required' => false,
                'attribute' => 'dossier',
            ])

            @include('form-components.create.multiple-select', [
                'label' => 'Zones',
                'required' => true,
                'attribute' => 'zones[]',
                'options' => $zones,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Bioequivalence',
                'required' => false,
                'attribute' => 'bioequivalence',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Down payment',
                'required' => false,
                'attribute' => 'additional_payment',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Validity period',
                'required' => false,
                'attribute' => 'patent_expiry',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.switch', [
                'label' => 'Registered in EU',
                'attribute' => 'registered_in_eu',
            ])

            @include('form-components.create.switch', [
                'label' => 'Sold in EU',
                'attribute' => 'marketed_in_eu',
            ])

            @include('form-components.create.textarea', [
                'label' => 'Comment',
                'required' => false,
                'attribute' => 'comment',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
