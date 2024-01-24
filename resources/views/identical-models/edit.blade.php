@extends('layouts.app', ['class' => 'identical-models-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [$model, '#' . $item->id],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('identical-models.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')
        <input type="hidden" name="model" value="{{ $model }}">

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Name',
                'required' => true,
                'attribute' => 'name',
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
