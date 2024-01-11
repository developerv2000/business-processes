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
        <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">
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
                'label' => 'Dosage',
                'value' => $generic->dose,
            ])

            @include('form-components.create.readonly-input', [
                'label' => 'Pack',
                'value' => $generic->pack,
            ])
        </div>

        <div class="form__divider">
            <x-form.group-validateable label="{{ __('Product status') }}" error-name="status_id" required="1">
                <select class="selectize-singular statusses-selectize selectize--manually-initializable" name="status_id" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" @selected($proposedChildStatus->id == $status->id)>{{ $status->name }}</option>
                    @endforeach
                </select>
            </x-form.group-validateable>
        </div>

        <div class="form__divider">
            <x-form.group label="{{ __('Search country') }}" required="1">
                <select class="selectize-multiple country-codes-selectize selectize--manually-initializable" name="country_code_ids[]" required multiple>
                    @foreach ($countryCodes as $country)
                        <option value="{{ $country->id }}" @selected($selectedCountryCodes->contains('id', $country->id))>{{ $country->name }}</option>
                    @endforeach
                </select>
            </x-form.group>

            @include('form-components.create.multiple-select', [
                'label' => 'Responsible',
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
        </div>

        <div class="processes-create__year-inputs-container">@include('processes.create.year-inputs')</div>
        <div class="processes-create__stage-inputs-container">@include('processes.create.stage-inputs')</div>

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
