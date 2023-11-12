<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="44">
                @include('tables.components.th-edit')
            </th>

            <th width="100">{{ __('Photo') }}</th>

            <th width="240">
                @include('tables.components.th-static-link', ['text' => 'Name', 'orderBy' => 'name'])
            </th>

            <th width="140">{{ __('Roles') }}</th>

            <th width="180">{{ __('Email') }}</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-edit', ['href' => route('users.edit', $item->id)])
                </td>

                <td>
                    <img class="td__image" src="{{ asset('img/users/' . $item->photo) }}">
                </td>

                <td>{{ $item->name }}</td>

                <td>
                    <div class="td__categories">
                        @foreach ($item->roles as $role)
                            <span class="badge badge--green">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </td>

                <td>{{ $item->email }}</td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
