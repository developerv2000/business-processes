@extends('layouts.app', ['class' => 'processes-index x-overflowed'])

@section('main')
    <div class="processes-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('processes.trash') }}" icon="delete" style="action">{{ __('Trash') }}</x-buttons.linked>

                <x-buttons.show-modal icon="view_column" style="action" modal-target=".edit-columns-modal">
                    {{ __('Columns') }}
                </x-buttons.show-modal>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>

                @unless (request()->user()->isTrainee())
                    <x-other.export-form action="{{ route('processes.export') }}" />
                @endunless
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.processes')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.edit-columns', ['action' => route('settings.update.processes'), 'id' => 'processes-columns-form'])
    @include('modals.multiple-delete', ['action' => route('processes.destroy'), 'permanently' => false])
@endsection

@section('rightbar')
    @include('filters.processes', ['action' => route('processes.index')])
@endsection
