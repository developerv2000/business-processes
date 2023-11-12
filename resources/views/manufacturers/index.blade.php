@extends('layouts.app', ['class' => 'manufacturers-index x-overflowed'])

@section('main')
    <div class="manufacturers-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('manufacturers.create') }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>

                <x-buttons.linked href="{{ route('manufacturers.trash') }}" icon="delete" style="action">{{ __('Trash') }}</x-buttons.linked>

                <x-buttons.show-modal icon="view_column" style="action" modal-target=".edit-columns-modal">
                    {{ __('Columns') }}
                </x-buttons.show-modal>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>

                <x-other.export-form action="{{ route('manufacturers.export') }}" />
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.manufacturers')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.edit-columns', ['action' => route('settings.update.manufacturers'), 'id' => 'manufacturers-columns-form'])
    @include('modals.multiple-delete', ['action' => route('manufacturers.destroy'), 'permanently' => false])
@endsection

@section('rightbar')
    @include('filters.manufacturers', ['action' => route('manufacturers.index')])
@endsection
