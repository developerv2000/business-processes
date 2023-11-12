@extends('layouts.app', ['class' => 'mnns-index'])

@section('main')
    <div class="mnns-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('mnns.create') }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.mnns')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.multiple-delete', ['action' => route('mnns.destroy'), 'permanently' => true])
@endsection

@section('rightbar')
    @include('filters.mnns')
@endsection
