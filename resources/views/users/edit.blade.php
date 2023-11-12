@extends('layouts.app', ['class' => 'users-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Users'), __('Edit'), $item->name],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>

            <x-buttons.show-modal icon="remove" style="action" class="prehead__actions-btn" modal-target=".single-delete-modal">
                {{ __('Delete') }}
            </x-buttons.show-modal>
        </div>
    </div>

    <x-errors.single name="user-deletion" />

    <form class="form main-form edit-form" action="{{ route('users.update', $item->id) }}" method="POST" id="edit-form" enctype="multipart/form-data">
        @csrf
        @include('form-components.edit.previous-url-input')

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

            @include('form-components.edit.multiple-select', [
                'label' => 'Roles',
                'required' => true,
                'attribute' => 'roles[]',
                'relationName' => 'roles',
                'options' => $roles,
                'optionsCaptionAttribute' => 'name',
            ])

            @include('form-components.edit.file-input', [
                'label' => 'Photo',
                'required' => false,
                'attribute' => 'photo',
                'accept' => '.png, .jpg, .jpeg',
            ])

            @include('form-components.edit.password', [
                'required' => false,
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>

    @include('modals.single-delete', ['action' => route('users.destroy'), 'permanently' => true])
@endsection
