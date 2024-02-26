@extends('layouts.app', ['class' => 'info-create rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Info'), __('Add new element')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('info.store') }}" method="POST" id="create-form">
        @csrf

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'Name',
                'required' => true,
                'attribute' => 'name',
            ])

            @include('form-components.create.switch', [
                'label' => 'Collapse',
                'attribute' => 'is_collapse',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Parent',
                'required' => false,
                'attribute' => 'parent_id',
                'options' => $blocks,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.simditor-textarea', [
                'label' => 'Content',
                'required' => true,
                'attribute' => 'content',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
