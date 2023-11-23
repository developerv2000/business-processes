@switch($column['name'])
    @case('ID')
        {{ $item->id }}
    @break

    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('processes.edit', $item->id)])
    @break

    @case('НПП/УДС')
        <span @class([
            'badge',
            'badge--yellow' => $item->manufacturer->category->name == 'УДС',
            'badge--purple' => $item->manufacturer->category->name == 'НПП',
        ])>
            {{ $item->manufacturer->category->name }}
        </span>
    @break

    @case('Manufacturer')
        {{ $item->manufacturer->name }}
    @break

    @case('Manuf/country')
        {{ $item->manufacturer->country->name }}
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
    @break

    @case('Prod/categ')
        <span class="badge badge--green">{{ $item->generic->category->name }}</span>
    @break

    @case('Generic')
        @include('tables.components.td-limited-text', ['text' => $item->generic->mnn->name])
    @break

    @case('Form')
        {{ $item->generic->form->name }}
    @break

    @case('Dose')
        @include('tables.components.td-limited-text', ['text' => $item->generic->dose])
    @break

    @case('Pack')
        {{ $item->generic->pack }}
    @break

    @case('General status')
        {{ $item->status->parent->name }}
    @break

    @case('Owners')
        @foreach ($item->owners as $owner)
            {{ $owner->name }}<br>
        @endforeach
    @break

    @case('Days past')
        {{ $item->days_past }}
    @break

    @case('Date')
        @include('tables.components.td-date', ['attribute' => 'status_update_date'])
    @break

    @case('Country')
        {{ $item->countryCode->name }}
    @break

    @case('Status')
        {{ $item->status->name }}
    @break

    @case('Process date')
        @include('tables.components.td-date', ['attribute' => 'date'])
    @break

    @default
        <h3>Undefined!</h3>
    @break

@endswitch
