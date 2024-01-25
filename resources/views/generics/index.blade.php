@extends('layouts.app', ['class' => 'generics-index x-overflowed'])

@section('main')
    <div class="generics-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Filtered items') . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('generics.create') }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>

                <x-buttons.linked href="{{ route('generics.trash') }}" icon="delete" style="action">{{ __('Trash') }}</x-buttons.linked>

                <x-buttons.show-modal icon="view_column" style="action" modal-target=".edit-columns-modal">
                    {{ __('Columns') }}
                </x-buttons.show-modal>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>

                <x-other.export-form action="{{ route('generics.export') }}" />

                {{-- Export VP --}}
                @if (request()->manufacturer_id)
                    <form class="export-form export-generics-vp-form" action="{{ route('generics.export-vp') }}" method="POST">
                        @csrf
                        <input type="hidden" name="manufacturer_id" value="{{ request()->manufacturer_id }}">

                        <button class="button button--action">
                            <span class="button__icon material-symbols-outlined">download</span>
                            <span class="button__text">{{ __('VP') }}</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            @include('tables.index-pages.generics')
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.edit-columns', ['action' => route('settings.update.generics'), 'id' => 'generics-columns-form'])
    @include('modals.multiple-delete', ['action' => route('generics.destroy'), 'permanently' => false])
@endsection

@section('rightbar')
    @include('filters.generics', ['action' => route('generics.index')])
@endsection
