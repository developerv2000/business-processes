@extends('layouts.app', ['class' => 'comments-edit rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Comment'), __('Edit'), '# ' . $item->id],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <x-form.submit icon="done_outline" style="action" class="prehead__actions-btn" form="edit-form">{{ __('Update') }}</x-form.submit>
        </div>
    </div>

    <form class="form main-form edit-form" action="{{ route('comments.update', $item->id) }}" method="POST" id="edit-form">
        @csrf
        @include('form-components.edit.previous-url-input')

        <div class="form__divider">
            @include('form-components.edit.textarea', [
                'label' => 'Comment',
                'required' => true,
                'attribute' => 'body',
            ])

            @include('form-components.edit.text-input', [
                'label' => 'Date of creation',
                'required' => true,
                'attribute' => 'created_at',
            ])

            <x-form.submit class="main-form__submit">{{ __('Update') }}</x-form.submit>
        </div>
    </form>
@endsection
