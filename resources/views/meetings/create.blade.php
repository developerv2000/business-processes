@extends('layouts.app', ['class' => 'meetings-create rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Meetings'), __('Add new element')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('meetings.store') }}" method="POST" id="create-form">
        @csrf

        <div class="form__divider">
            @include('form-components.create.simple-select', [
                'label' => 'Year',
                'required' => true,
                'attribute' => 'year',
                'options' => $availableYears,
            ])

            @include('form-components.create.belongs-to-select', [
                'label' => 'Manufacturer',
                'required' => true,
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Who met',
                'required' => false,
                'attribute' => 'who_met',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.create.textarea', [
                'label' => 'Plan',
                'required' => false,
                'attribute' => 'plan',
            ])

            @include('form-components.create.textarea', [
                'label' => 'Topic',
                'required' => false,
                'attribute' => 'topic',
            ])

            @include('form-components.create.textarea', [
                'label' => 'Result',
                'required' => false,
                'attribute' => 'result',
            ])

            @include('form-components.create.textarea', [
                'label' => 'Outside the exhibition',
                'required' => false,
                'attribute' => 'outside_the_exhibition',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
