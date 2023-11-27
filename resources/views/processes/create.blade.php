@extends('layouts.app', ['class' => 'processes-create rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('VPS'), __('Add new element')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('processes.store') }}" method="POST" id="create-form">
        @csrf

        <input type="hidden" name="generic_id" value="{{ $generic->id }}">

        <div class="form__divider">
            @include('form-components.create.readonly-input', [
                'label' => 'Manufacturer',
                'value' => $generic->manufacturer->name,
            ])

            @include('form-components.create.readonly-input', [
                'label' => 'Generic',
                'value' => $generic->mnn->name,
            ])

            @include('form-components.create.readonly-input', [
                'label' => 'Form',
                'value' => $generic->form->name,
            ])

            @include('form-components.create.readonly-input', [
                'label' => 'Dose',
                'value' => $generic->dose,
            ])

            @include('form-components.create.readonly-input', [
                'label' => 'Pack',
                'value' => $generic->pack,
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.belongs-to-select', [
                'label' => 'Country',
                'required' => true,
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Status',
                'required' => true,
                'attribute' => 'status_id',
                'options' => $statuses,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.multiple-select', [
                'label' => 'Owners',
                'required' => true,
                'attribute' => 'owners[]',
                'options' => $owners,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.text-input', [
                'type' => 'date',
                'label' => 'Process date',
                'required' => true,
                'attribute' => 'date',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
