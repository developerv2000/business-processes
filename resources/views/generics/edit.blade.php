@extends('layouts.app', ['class' => 'generics-edit rightbarless'])

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

    <form class="form main-form edit-form" action="{{ route('generics.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')

        <div class="form__divider">
            @include('form-components.edit.belongs-to-select', [
                'label' => 'Manufacturer',
                'required' => true,
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
                'optionsCaptionAttribute' => 'name',
            ])

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
                'options' => $productForms,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Dosage',
                'required' => false,
                'attribute' => 'dose',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Pack',
                'required' => false,
                'attribute' => 'pack',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Manufacturer Brand',
                'required' => false,
                'attribute' => 'brand',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Product category',
                'required' => true,
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'MOQ',
                'required' => false,
                'attribute' => 'minimum_volume',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Shelf life',
                'required' => true,
                'attribute' => 'expiration_date_id',
                'options' => $expirationDates,
                'optionsCaptionAttribute' => 'limit',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Dossier',
                'required' => false,
                'attribute' => 'dossier',
            ])

            @include('form-components.edit.multiple-select', [
                'label' => 'Zones',
                'required' => true,
                'attribute' => 'zones[]',
                'relationName' => 'zones',
                'options' => $zones,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Bioequivalence',
                'required' => false,
                'attribute' => 'bioequivalence',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Down payment',
                'required' => false,
                'attribute' => 'additional_payment',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Validity period',
                'required' => false,
                'attribute' => 'patent_expiry',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.switch', [
                'label' => 'Registered in EU',
                'attribute' => 'registered_in_eu',
            ])

            @include('form-components.edit.switch', [
                'label' => 'Sold in EU',
                'attribute' => 'marketed_in_eu',
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

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
