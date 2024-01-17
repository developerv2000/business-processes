<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            @include('tables.components.th-checkbox')

            <th width="70">{{ __('app.restore-shortcut') }}</th>

            <th width="112">
                @include('tables.components.th-static-link', ['text' => 'Deleted at', 'orderBy' => 'deleted_at'])
            </th>

            <th width="82">{{ __('Status') }}</th>
            <th width="86">{{ __('Country') }}</th>
            <th width="106">{{ __('Priority') }}</th>
            <th width="98">{{ __('Source') }}</th>
            <th width="140">{{ __('Generic') }}</th>
            <th width="140">{{ __('Form') }}</th>
            <th width="140">{{ __('Basic form') }}</th>
            <th width="160">{{ __('Dosage') }}</th>
            <th width="110">{{ __('Pack') }}</th>
            <th width="64">{{ __('MAH') }}</th>
            <th width="136">{{ __('Date of forecast') }}</th>
            <th width="150">{{ __('Portfolio manager') }}</th>
            <th width="138">{{ __('Date of creation') }}</th>
            <th width="72">{{ __('ID') }}</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($items as $item)
            <tr @class(['tr--whitesmoke' => $item->notActive()])>
                @include('tables.components.td-checkbox')

                <td>
                    @include('tables.components.td-restore')
                </td>

                <td>
                    @include('tables.components.td-date', ['attribute' => 'deleted_at'])
                </td>

                <td>{{ __($item->status->name) }}</td>

                <td>{{ $item->countryCode->name }}</td>

                <td>
                    <span @class([
                        'badge',
                        'badge--red' => $item->priority->name == 'A',
                        'badge--green' => $item->priority->name == 'B',
                        'badge--yellow' => $item->priority->name == 'C',
                    ])>
                        {{ $item->priority->name }}
                    </span>
                </td>

                <td>{{ $item->source->name }}</td>

                <td>{{ $item->mnn->name }}</td>

                <td>{{ $item->form->name }}</td>

                <td>{{ $item->form->parent ? $item->form->parent->name : $item->form->name }}</td>

                <td>@include('tables.components.td-limited-text', ['text' => $item->dose])</td>

                <td>{{ $item->pack }}</td>

                <td>{{ $item->promoCompany->name }}</td>

                <td>@include('tables.components.td-date', ['attribute' => 'date_of_forecast'])</td>

                <td>{{ $item->portfolioManager?->name }}</td>

                <td>@include('tables.components.td-date', ['attribute' => 'created_at'])</td>

                <td>{{ $item->id }}</td>
            </tr>
        @endforeach
    </tbody> {{-- Body end --}}
</table>
