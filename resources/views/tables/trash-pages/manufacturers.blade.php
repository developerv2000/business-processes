<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="70">{{ __('app.restore-shortcut') }}</th>

            <th width="112">
                @include('tables.components.th-static-link', ['text' => 'Deleted at', 'orderBy' => 'deleted_at'])
            </th>

            <th width="140">
                @include('tables.components.th-static-link', ['text' => 'Manufacturer', 'orderBy' => 'name'])
            </th>

            <th width="140">
                @include('tables.components.th-static-link', ['text' => 'Country', 'orderBy' => 'country_id'])
            </th>

            <th width="142">
                @include('tables.components.th-static-link', ['text' => 'BDM', 'orderBy' => 'bdm_user_id'])
            </th>

            <th width="142">
                @include('tables.components.th-static-link', ['text' => 'Analyst', 'orderBy' => 'analyst_user_id'])
            </th>

            <th width="90">
                @include('tables.components.th-static-link', ['text' => 'ID', 'orderBy' => 'id'])
            </th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr title="{{ $item->name }}">
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-restore')
                </td>

                <td>
                    @include('tables.components.td-date', ['attribute' => 'deleted_at'])
                </td>

                <td>{{ $item->name }}</td>

                <td>{{ $item->country->name }}</td>

                <td>
                    <x-other.ava image="{{ $item->bdm->photo }}" name="{{ $item->bdm->name }}"></x-other.ava>
                </td>

                <td>
                    <x-other.ava image="{{ $item->analyst->photo }}" name="{{ $item->analyst->name }}"></x-other.ava>
                </td>

                <td>{{ $item->id }}</td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
