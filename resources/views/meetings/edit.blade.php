@extends('layouts.app', ['class' => 'meetings-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Meetings'), __('Edit'), $item->year, $item->manufacturer->name],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('meetings.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')

        <div class="form__divider">
            @include('form-components.edit.simple-select', [
                'label' => 'Year',
                'required' => true,
                'attribute' => 'year',
                'options' => $availableYears,
            ])

            @include('form-components.edit.belongs-to-select', [
                'label' => 'Manufacturer',
                'required' => true,
                'attribute' => 'manufacturer_id',
                'options' => $manufacturers,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Who met',
                'required' => false,
                'attribute' => 'who_met',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.textarea', [
                'label' => 'Plan',
                'required' => false,
                'attribute' => 'plan',
            ])

            @include('form-components.edit.textarea', [
                'label' => 'Topic',
                'required' => false,
                'attribute' => 'topic',
            ])

            @include('form-components.edit.textarea', [
                'label' => 'Result',
                'required' => false,
                'attribute' => 'result',
            ])

            @include('form-components.edit.textarea', [
                'label' => 'Outside the exhibition',
                'required' => false,
                'attribute' => 'outside_the_exhibition',
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
