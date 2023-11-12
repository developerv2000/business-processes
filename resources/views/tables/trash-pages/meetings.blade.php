<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="54">
                @include('tables.components.th-static-link', ['text' => 'ID', 'orderBy' => 'id'])
            </th>

            <th width="70">{{ __('app.restore-shortcut') }}</th>

            <th width="112">
                @include('tables.components.th-static-link', ['text' => 'Deleted at', 'orderBy' => 'deleted_at'])
            </th>

            <th width="144">{{ __('Country') }}</th>

            <th width="140">{{ __('Manufacturer') }}</th>

            <th width="142">{{ __('Who met') }}</th>

            <th width="320">{{ __('Plan') }}</th>

            <th width="320">{{ __('Topic') }}</th>

            <th width="320">{{ __('Result') }}</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr title="{{ $item->name }}">
                @include('tables.components.td-checkbox')

                <td>{{ $item->id }}</td>

                <td>
                    @include('tables.components.td-restore')
                </td>

                <td>
                    @include('tables.components.td-date', ['attribute' => 'deleted_at'])
                </td>

                <td>{{ $item->manufacturer->country->name }}</td>

                <td>{{ $item->manufacturer->name }}</td>

                <td>{{ $item->who_met }}</td>

                <td>
                    @include('tables.components.td-limited-text', ['text' => $item->plan])
                </td>

                <td>
                    @include('tables.components.td-limited-text', ['text' => $item->topic])
                </td>

                <td>
                    @include('tables.components.td-limited-text', ['text' => $item->result])
                </td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
