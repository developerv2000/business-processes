{{-- First Table --}}
<table class="table styled-box">
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


{{-- Second Table --}}
<table class="table styled-box" style="margin-top: 40px">
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
                    <td>{{ $month['stage_' . $status->stage . '_transitional_statusses_count'] }}</td>
                @endforeach

                <td>{{ $status->total_transitional_per_year }}</td>
            </tr>
        @endforeach

        <tr>
            <td>{{ __('Всего') }}</td>

            @foreach ($monthes as $month)
                <td>{{ $month['transitional_statusses_total_count'] }}</td>
            @endforeach

            <td>{{ $yearTotalTransitionalProcessesCount }}</td>
        </tr>
    </tbody> {{-- Body end --}}
</table>
