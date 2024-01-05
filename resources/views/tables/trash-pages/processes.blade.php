<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="70">{{ __('app.restore-shortcut') }}</th>

            <th width="112">
                @include('tables.components.th-static-link', ['text' => 'Deleted at', 'orderBy' => 'deleted_at'])
            </th>

            <th width="112">
                @include('tables.components.th-static-link', ['text' => 'Date', 'orderBy' => 'date'])
            </th>

            <th width="144">{{ __('Search country') }}</th>

            <th width="140">{{ __('Manufacturer') }}</th>

            <th width="142">{{ __('BDM') }}</th>

            <th width="142">{{ __('Analyst') }}</th>

            <th width="150">{{ __('Generic') }}</th>

            <th width="140">{{ __('Form') }}</th>

            <th width="160">{{ __('Dosage') }}</th>

            <th width="180">{{ __('Pack') }}</th>

            <th width="116">{{ __('General STATUS') }}</th>

            <th width="80">{{ __('Product STATUS') }}</th>

            <th width="120">{{ __('Days have passed!') }}</th>

            <th width="90">
                @include('tables.components.th-static-link', ['text' => 'ID', 'orderBy' => 'id'])
            </th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr title="{{ $item->countryCode->name }}">
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-restore')
                </td>

                <td>
                    @include('tables.components.td-date', ['attribute' => 'deleted_at'])
                </td>

                <td>
                    @include('tables.components.td-date', ['attribute' => 'date'])
                </td>

                <td>{{ $item->countryCode->name }}</td>

                <td>{{ $item->manufacturer->name }}</td>

                <td>
                    <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
                </td>

                <td>
                    <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
                </td>

                <td>
                    @include('tables.components.td-limited-text', ['text' => $item->generic->mnn->name])
                </td>

                <td>{{ $item->generic->form->name }}</td>

                <td>@include('tables.components.td-limited-text', ['text' => $item->generic->dose])</td>

                <td>{{ $item->generic->pack }}</td>

                <td>{{ $item->status->name }}</td>

                <td>{{ $item->status->parent->name }}</td>

                <td>{{ $item->days_past }}</td>

                <td>{{ $item->id }}</td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
