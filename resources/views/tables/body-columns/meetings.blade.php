@switch($column['name'])
    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('meetings.edit', $item->id)])
    @break

    @case('Year')
        {{ $item->year }}
    @break

    @case('Country')
        {{ $item->manufacturer->country->name }}
    @break

    @case('Manufacturer')
        {{ $item->manufacturer->name }}
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
    @break

    @case('Who met')
        {{ $item->who_met }}
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
    @break

    @case('Plan')
        @include('tables.components.td-limited-text', ['text' => $item->plan])
    @break

    @case('Topic')
        @include('tables.components.td-limited-text', ['text' => $item->topic])
    @break

    @case('Result')
        @include('tables.components.td-limited-text', ['text' => $item->result])
    @break

    @case('Outside the exhibition')
        @include('tables.components.td-limited-text', ['text' => $item->outside_the_exhibition])
    @break

    @case('ID')
        {{ $item->id }}
    @break
@endswitch
