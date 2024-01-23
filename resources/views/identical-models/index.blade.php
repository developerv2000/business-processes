@extends('layouts.app', ['class' => 'identical-models-index rightbarless'])

@section('main')
    <div class="identical-models-index__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [$model . ' - ' . $items->total()],
                'fullScreen' => true,
            ])

            <div class="prehead__actions">
                <x-buttons.linked href="{{ route('identical-models.create', $model) }}" icon="add" style="action">{{ __('New') }}</x-buttons.linked>

                <x-buttons.show-modal icon="remove" style="action" modal-target=".multiple-delete-modal">
                    {{ __('Delete') }}
                </x-buttons.show-modal>
            </div>
        </div>

        <div class="table-wrapper thin-scrollbar">
            <table class="table">
                {{-- Head start --}}
                <thead>
                    <tr>
                        @include('tables.components.th-checkbox')

                        <th width="44">
                            @include('tables.components.th-edit')
                        </th>

                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Usage count') }}</th>
                    </tr>
                </thead> {{-- Head end --}}

                {{-- Body Start --}}
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            @include('tables.components.td-checkbox')

                            <td>
                                @include('tables.components.td-edit', ['href' => route('identical-models.edit', ['model' => $model, 'id' => $item->id])])
                            </td>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->usage_count }}</td>
                        </tr>
                    @endforeach
                </tbody> {{-- Body end --}}
            </table>
        </div>

        {{ $items->links('layouts.pagination') }}

        @include('tables.styles.pagination-height-validation')
    </div>

    @include('modals.multiple-delete', ['action' => route('identical-models.destroy'), 'permanently' => true])
@endsection
