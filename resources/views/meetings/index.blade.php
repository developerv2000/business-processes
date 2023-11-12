@extends('layouts.app', ['class' => 'meetings-index x-overflowed'])

@section('main')
    <div class="meetings-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('meetings.create') }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>

                <x-buttons.linked href="{{ route('meetings.trash') }}" icon="delete" style="action">{{ __('Trash') }}</x-buttons.linked>

                <x-buttons.show-modal icon="view_column" style="action" modal-target=".edit-columns-modal">
                    {{ __('Columns') }}
                </x-buttons.show-modal>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.meetings')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.edit-columns', ['action' => route('settings.update.meetings'), 'id' => 'meetings-columns-form'])
    @include('modals.multiple-delete', ['action' => route('meetings.destroy'), 'permanently' => false])
@endsection

@section('rightbar')
    @include('filters.meetings', ['action' => route('meetings.index')])
@endsection
