@extends('layouts.app', ['class' => 'users-index rightbarless'])

@section('main')
    <div class="users-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Users') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('users.create') }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.users')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>
@endsection
