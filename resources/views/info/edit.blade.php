@extends('layouts.app', ['class' => 'info-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Info'), __('Edit'), $item->id],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('info.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')

        <div class="form__divider">
            @include('form-components.edit.text-input', [
                'label' => 'Name',
                'required' => true,
                'attribute' => 'name',
            ])

            @include('form-components.edit.switch', [
                'label' => 'Collapse',
                'attribute' => 'is_collapse',
            ])

            @include('form-components.edit.simditor-textarea', [
                'label' => 'Content',
                'required' => true,
                'attribute' => 'content',
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
