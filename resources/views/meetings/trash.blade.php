@extends('layouts.app', ['class' => 'meetings-trash x-overflowed'])

@section('main')
    <div class="meetings-trash__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Meetings'), __('Trash'), __('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.show-modal icon="remove" style="action" class="prehead__actions-btn" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.trash-pages.meetings')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @if (request()->user()->isAdmin())
        @include('modals.multiple-delete', ['action' => route('meetings.destroy'), 'permanently' => true])
    @endif

    @include('modals.single-restore', ['action' => route('meetings.restore')])
@endsection

@section('rightbar')
    @include('filters.meetings', ['action' => route('meetings.trash')])
@endsection
