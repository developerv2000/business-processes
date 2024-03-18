<table class="table">
    {{-- Head start --}}
    <thead>
        <tr>
            <th width="146">{{ __('Product status An*') }}</th>

            @foreach ($monthes as $month)
                <th width="100">{{ $month['name'] }}</th>
            @endforeach

            <th width="100">{{ __('Total') }}</th>
        </tr>
    </thead> {{-- Head end --}}

    {{-- Body Start --}}
    <tbody>
        @foreach ($statusses as $status)
            <tr>
                <td>{{ $status->name }}</td>

                @foreach ($monthes as $month)
                    <td>{{ $month['stage_' . $status->stage . '_current_statusses_count'] }}</td>
                @endforeach

                <td>{{ $status->total_per_year }}</td>
            </tr>
        @endforeach

        <tr>
            <td>{{ __('Всего') }}</td>

            @foreach ($monthes as $month)
                <td>{{ $month['current_statusses_total_count'] }}</td>
            @endforeach

            <td>{{ $yearTotalProcessesCount }}</td>
        </tr>
    </tbody> {{-- Body end --}}
</table>
