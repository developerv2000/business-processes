@extends('layouts.app', ['class' => 'kvpp-comments rightbarless'])

@section('main')
    <div class="prehead prehead--intended styled-box">
        @include('layouts.breadcrumbs', [
            'crumbs' => [$item->brand, __('All comments')],
            'fullScreen' => false,
        ])
    </div>

    <div class="comments-container">
        <h1 class="comments-container__title main-title">{{ __('Comments') }} ({{ $item->comments->count() }})</h1>

        @include('comments.form', ['commentableType' => 'App\Models\Kvpp'])
        @include('comments.list', ['comments' => $item->comments])
    </div>
@endsection
