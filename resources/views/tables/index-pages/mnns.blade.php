<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="44">
                @include('tables.components.th-edit')
            </th>

            <th>
                @include('tables.components.th-static-link', ['text' => 'Name', 'orderBy' => 'name'])
            </th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-edit', ['href' => route('mnns.edit', $item->id)])
                </td>

                <td>
                    {{ $item->name }}
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
