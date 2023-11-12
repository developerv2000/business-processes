@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Static text --}}
    @case('Country')
    @case('BDM')
    @case('Who met')
    @case('Analyst')
    @case('Plan')
    @case('Topic')
    @case('Result')
    @case('Outside the exhibition')
        @include('tables.components.th-unlinked-title')
    @break

    {{-- Links --}}
    @case('ID')
        @include('tables.components.th-link', ['orderBy' => 'id'])
    @break

    @case('Year')
        @include('tables.components.th-link', ['orderBy' => 'year'])
    @break

    @case('Manufacturer')
        @include('tables.components.th-link', ['orderBy' => 'manufacturer_id'])
    @break

    @default
        <h3>Undefined!</h3>
    @break
@endswitch
