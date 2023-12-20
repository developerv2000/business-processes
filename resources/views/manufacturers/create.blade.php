@extends('layouts.app', ['class' => 'manufacturers-create rightbarless x-overflowed'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('EPP'), __('Add new element')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('manufacturers.store') }}" method="POST" id="create-form">
        @csrf

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'Manufacturer',
                'required' => true,
                'attribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Category',
                'required' => true,
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'BDM',
                'required' => true,
                'attribute' => 'bdm_user_id',
                'options' => $bdmUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.current-user-select', [
                'label' => 'Analyst',
                'required' => true,
                'attribute' => 'analyst_user_id',
                'options' => $analystUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Country',
                'required' => true,
                'attribute' => 'country_id',
                'options' => $countries,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'Website',
                'required' => false,
                'attribute' => 'website',
            ])

            @include('form-components.create.textarea', [
                'label' => 'About company',
                'required' => false,
                'attribute' => 'profile',
            ])

            @include('form-components.create.textarea', [
                'label' => 'Relationship',
                'required' => false,
                'attribute' => 'relationships',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.radiogroup', [
                'label' => 'Status',
                'required' => true,
                'attribute' => 'active',
                'options' => $statusOptions,
            ])

            @include('form-components.create.switch', [
                'label' => 'Important',
                'attribute' => 'important',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.unlisted-multiple-select-taggable', [
                'label' => 'Presence',
                'required' => false,
                'attribute' => 'presences[]',
            ])

            @include('form-components.create.multiple-select', [
                'label' => 'Zones',
                'required' => true,
                'attribute' => 'zones[]',
                'options' => $zones,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.multiple-select', [
                'label' => 'Product category',
                'required' => true,
                'attribute' => 'productCategories[]',
                'options' => $productCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.multiple-select', [
                'label' => 'Black list',
                'required' => false,
                'attribute' => 'blacklists[]',
                'options' => $blacklists,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.textarea', [
                'label' => 'Comment',
                'required' => false,
                'attribute' => 'comment',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
