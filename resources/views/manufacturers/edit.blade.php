@extends('layouts.app', ['class' => 'manufacturers-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('EPP'), __('Edit'), $item->name],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('manufacturers.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Manufacturer',
                'required' => true,
                'attribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Category',
                'required' => true,
                'attribute' => 'category_id',
                'options' => $categories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'BDM',
                'required' => true,
                'attribute' => 'bdm_user_id',
                'options' => $bdmUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Analyst',
                'required' => true,
                'attribute' => 'analyst_user_id',
                'options' => $analystUsers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Country',
                'required' => true,
                'attribute' => 'country_id',
                'options' => $countries,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Website',
                'required' => false,
                'attribute' => 'website',
            ])

            @include('form-components.edit.textarea', [
                'label' => 'About company',
                'required' => false,
                'attribute' => 'profile',
            ])

            @include('form-components.edit.textarea', [
                'label' => 'Relationship',
                'required' => false,
                'attribute' => 'relationships',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.radiogroup', [
                'label' => 'Status',
                'required' => true,
                'attribute' => 'active',
                'options' => $statusOptions,
            ])

            @include('form-components.edit.switch', [
                'label' => 'Important',
                'attribute' => 'important',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.unlisted-multiple-select-taggable', [
                'label' => 'Presence',
                'required' => false,
                'attribute' => 'presences[]',
                'relationName' => 'presences',
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.multiple-select', [
                'label' => 'Zones',
                'required' => true,
                'attribute' => 'zones[]',
                'relationName' => 'zones',
                'options' => $zones,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.multiple-select', [
                'label' => 'Product category',
                'required' => true,
                'attribute' => 'productCategories[]',
                'relationName' => 'productCategories',
                'options' => $productCategories,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.multiple-select', [
                'label' => 'Black list',
                'required' => false,
                'attribute' => 'blacklists[]',
                'relationName' => 'blacklists',
                'options' => $blacklists,
                'optionsCaptionAttribute' => 'name',
            ])
        </div>

        <div class="form__divider">
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
