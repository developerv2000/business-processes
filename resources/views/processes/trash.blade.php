@extends('layouts.app', ['class' => 'processes-trash x-overflowed'])

@section('main')
    <div class="processes-trash__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('VPS'), __('Trash'), __('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.show-modal icon="remove" style="action" class="prehead__actions-btn" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.trash-pages.processes')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>


    @if (request()->user()->isAdmin())
        @include('modals.multiple-delete', ['action' => route('processes.destroy'), 'permanently' => true])
    @endif

    @include('modals.single-restore', ['action' => route('processes.restore')])
@endsection

@section('rightbar')
    @include('filters.processes', ['action' => route('processes.trash')])
@endsection
