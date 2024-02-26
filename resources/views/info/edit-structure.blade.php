@extends('layouts.app', ['class' => 'info-edit-structure rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('Info'), __('Edit structure')],
            'fullScreen' => false,
        ])

        <div class="prehead__actions">
            <button class="button button--action" data-action="update-nestedset" data-url="{{ route('info.update-nestedset') }}">
                <span class="button__icon material-symbols-outlined">done_all</span>
                <span class="button__text">{{ __('Update') }}</span>
            </button>
        </div>
    </div>

    @include('nestedset.index')
@endsection
