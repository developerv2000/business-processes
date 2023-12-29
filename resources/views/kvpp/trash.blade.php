@extends('layouts.app', ['class' => 'kvpp-trash x-overflowed'])

@section('main')
    <div class="kvpp-trash__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('KVPP'), __('Trash'), __('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.show-modal icon="remove" style="action" class="prehead__actions-btn" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.trash-pages.kvpp')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>


    @if (request()->user()->isAdmin())
        @include('modals.multiple-delete', ['action' => route('kvpp.destroy'), 'permanently' => true])
    @endif

    @include('modals.single-restore', ['action' => route('kvpp.restore')])
@endsection

@section('rightbar')
    @include('filters.kvpp', ['action' => route('kvpp.trash')])
@endsection
