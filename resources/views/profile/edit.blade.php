@extends('layouts.app', ['class' => 'profile-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('My profile'), __('Edit')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="edit-form">
        @csrf

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Name',
                'required' => true,
                'attribute' => 'name',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Email',
                'type' => 'email',
                'required' => true,
                'attribute' => 'email',
            ])

            @include('form-components.edit.file-input', [
                'label' => 'Photo',
                'required' => false,
                'attribute' => 'photo',
                'accept' => '.png, .jpg, .jpeg',
            ])
        </div>

        <div class="form__divider">
            @include('form-components.edit.password-verification', [
                'required' => false,
            ])

            @include('form-components.edit.password', [
                'required' => false,
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
