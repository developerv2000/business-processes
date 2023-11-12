<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            @foreach ($visibleColumns as $column)
                <th width="{{ $column['width'] }}">
                    @include('tables.header-columns.generics')
                </th>
            @endforeach
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr title="{{ $item->brand }}">
                @include('tables.components.td-checkbox')

                @foreach ($visibleColumns as $column)
                    <td>
                        @include('tables.body-columns.generics')
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
