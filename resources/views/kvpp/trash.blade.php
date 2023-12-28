@extends('layouts.app', ['class' => 'generics-trash x-overflowed'])

@section('main')
    <div class="generics-trash__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('IVP'), __('Trash'), __('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.show-modal icon="remove" style="action" class="prehead__actions-btn" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.trash-pages.generics')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>


    @if (request()->user()->isAdmin())
        @include('modals.multiple-delete', ['action' => route('generics.destroy'), 'permanently' => true])
    @endif

    @include('modals.single-restore', ['action' => route('generics.restore')])
@endsection

@section('rightbar')
    @include('filters.generics', ['action' => route('generics.trash')])
@endsection
