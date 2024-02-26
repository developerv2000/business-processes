@extends('layouts.app', ['class' => 'info-index x-overflowed'])

@section('main')
    <div class="info-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('info.create') }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>
                <x-buttons.linked href="{{ route('info.edit-nestedset') }}" icon="sort" style="action">{{ __('Edit structure') }}</x-buttons.linked>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.info')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.multiple-delete', ['action' => route('info.destroy'), 'permanently' => true])
@endsection

@section('rightbar')
    @include('filters.info', ['action' => route('info.index')])
@endsection
