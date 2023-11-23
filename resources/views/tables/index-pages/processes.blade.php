<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            @foreach ($visibleColumns as $column)
                <th width="{{ $column['width'] }}">
                    @include('tables.header-columns.processes')
                </th>
            @endforeach
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr title="{{ $item->generic->mnn->name }}">
                @include('tables.components.td-checkbox')

                @foreach ($visibleColumns as $column)
                    <td>
                        @include('tables.body-columns.processes')
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
