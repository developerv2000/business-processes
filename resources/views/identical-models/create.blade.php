@extends('layouts.app', ['class' => 'identical-models-create rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [$model],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('identical-models.store') }}" method="POST" id="create-form">
        @csrf
        <input type="hidden" name="model" value="{{ $model }}">

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'Name',
                'required' => true,
                'attribute' => 'name',
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
