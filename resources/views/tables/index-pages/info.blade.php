<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="44">
                @include('tables.components.th-edit')
            </th>

            <th width="240">
                @include('tables.components.th-static-link', ['text' => 'Name', 'orderBy' => 'name'])
            </th>

            <th width="240">{{ __('Content') }}</th>
            <th width="100">{{ __('Collapse') }}</th>
            <th width="140">{{ __('Parent') }}</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-edit', ['href' => route('info.edit', $item->id)])
                </td>

                <td>{{ $item->name }}</td>

                <td>
                    @include('tables.components.td-limited-text', ['text' => $item->content])
                </td>

                <td>{{ $item->is_collapse ? __('Yes') : __('No') }}</td>

                <td>{{ $item->parent?->name }}</td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
