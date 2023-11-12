@extends('layouts.app', ['class' => 'manufacturers-trash x-overflowed'])

@section('main')
    <div class="manufacturers-trash__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('EPP'), __('Trash'), __('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                @if (request()->user()->isAdmin())
                    <x-buttons.show-modal icon="remove" style="action" class="prehead__actions-btn" modal-target=".multiple-delete-modal">
                        {{ __('Delete') }}
                    </x-buttons.show-modal>
                @endif
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.trash-pages.manufacturers')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @if (request()->user()->isAdmin())
        @include('modals.multiple-delete', ['action' => route('manufacturers.destroy'), 'permanently' => true])
    @endif

    @include('modals.single-restore', ['action' => route('manufacturers.restore')])
@endsection

@section('rightbar')
    @include('filters.manufacturers', ['action' => route('manufacturers.trash')])
@endsection
