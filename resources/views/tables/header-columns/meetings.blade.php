@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Links --}}
    @case('Year')
        @include('tables.components.th-link', ['orderBy' => 'year'])
    @break

    @case('Manufacturer')
        @include('tables.components.th-link', ['orderBy' => 'manufacturer_id'])
    @break

    @case('ID')
        @include('tables.components.th-link', ['orderBy' => 'id'])
    @break

    @default
        {{-- Static text --}}
        @include('tables.components.th-unlinked-title')
    @break
@endswitch
