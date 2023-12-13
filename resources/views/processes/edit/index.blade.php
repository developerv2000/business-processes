@extends('layouts.app', ['class' => 'processes-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('VPS'), __('Edit'), $item->countryCode->name . ' # ' . $item->id],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('processes.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')
        <input type="hidden" name="id" value="{{ $item->id }}">

        <div class="form__divider">
            <x-form.group-validateable label="{{ __('Status') }}" error-name="status_id" required="1">
                <select class="selectize-singular statusses-selectize selectize--manually-initializable" name="status_id" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" @selected($item->status->id == $status->id)>{{ $status->name }}</option>
                    @endforeach
                </select>
            </x-form.group-validateable>
        </div>

        <div class="form__divider">
            @include('form-components.edit.belongs-to-select', [
                'label' => 'Country code',
                'required' => true,
                'attribute' => 'country_code_id',
                'options' => $countryCodes,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.multiple-select', [
                'label' => 'Owners',
                'required' => true,
                'attribute' => 'owners[]',
                'relationName' => 'owners',
                'options' => $owners,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Process date',
                'type' => 'date',
                'required' => true,
                'attribute' => 'date',
            ])
        </div>

        <div class="processes-edit__stage-inputs-container">@include('processes.edit.stage-inputs', ['processStage' => $item->status->parent->stage])</div>

        <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
    </form>
@endsection
