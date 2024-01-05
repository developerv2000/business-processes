@extends('layouts.app', ['class' => 'processes-comments rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [__('VPS') . ' #' . $item->id, __('All comments')],
            'fullScreen' => false,
        ])
    </div>

    <div class="comments-container">
        <h1 class="comments-container__title main-title">{{ __('Comments') }} ({{ $item->comments->count() }})</h1>

        @include('comments.form', ['commentableType' => 'App\Models\Process'])
        @include('comments.list', ['comments' => $item->comments])
    </div>
@endsection
