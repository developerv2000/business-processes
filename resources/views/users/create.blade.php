@extends('layouts.app', ['class' => 'users-create rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Users'), __('Add new element')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="add" style="action" class="prehead__actions-btn" form="create-form">{{ __('Store') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form create-form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
        @csrf

        <div class="form__divider">
            @include('form-components.create.text-input', [
                'label' => 'Name',
                'required' => true,
                'attribute' => 'name',
            ])

            @include('form-components.create.text-input', [
                'label' => 'Email',
                'type' => 'email',
                'required' => true,
                'attribute' => 'email',
            ])

            @include('form-components.create.multiple-select', [
                'label' => 'Roles',
                'required' => true,
                'attribute' => 'roles[]',
                'options' => $roles,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.create.file-input', [
                'label' => 'Photo',
                'required' => true,
                'attribute' => 'photo',
                'accept' => '.png, .jpg, .jpeg',
            ])

            @include('form-components.create.password', [
                'required' => true,
            ])

            <x-form.submit class="main-form__submit">{{ __('Store') }}</x-form.submit>
        </div>
    </form>
@endsection
