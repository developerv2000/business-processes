<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="70">{{ __('app.restore-shortcut') }}</th>

            <th width="112">
                @include('tables.components.th-static-link', ['text' => 'Deleted at', 'orderBy' => 'deleted_at'])
            </th>

            <th width="84">{{ __('Category') }}</th>

            <th width="144">{{ __('Country') }}</th>

            <th width="140">{{ __('Manufacturer') }}</th>

            <th width="182">{{ __('Manufacturer Brand') }}</th>

            <th width="180">{{ __('Generic') }}</th>

            <th width="142">{{ __('BDM') }}</th>

            <th width="142">{{ __('Analyst') }}</th>

            <th width="90">
                @include('tables.components.th-static-link', ['text' => 'ID', 'orderBy' => 'id'])
            </th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr>
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-restore')
                </td>

                <td>
                    @include('tables.components.td-date', ['attribute' => 'deleted_at'])
                </td>

                <td>
                    <span @class([
                        'badge',
                        'badge--yellow' => $item->manufacturer->category->name == 'УДС',
                        'badge--purple' => $item->manufacturer->category->name == 'НПП',
                    ])>
                        {{ $item->manufacturer->category->name }}
                    </span>
                </td>

                <td>{{ $item->manufacturer->country->name }}</td>

                <td>{{ $item->manufacturer->name }}</td>

                <td>{{ $item->brand }}</td>

                <td>
                    @include('tables.components.td-limited-text', ['text' => $item->mnn->name])
                </td>

                <td>
                    <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
                </td>

                <td>
                    <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
                </td>

                <td>{{ $item->id }}</td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
