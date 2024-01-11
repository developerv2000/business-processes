@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Links --}}
    @case('Date')
        @include('tables.components.th-link', ['orderBy' => 'status_update_date'])
    @break

    @case('Search country')
        @include('tables.components.th-link', ['orderBy' => 'country_code_id'])
    @break

    @case('Product status')
        @include('tables.components.th-link', ['orderBy' => 'status_id'])
    @break

    @case('Date of forecast')
        @include('tables.components.th-link', ['orderBy' => 'stage_2_start_date'])
    @break

    @case('Process date')
        @include('tables.components.th-link', ['orderBy' => 'date'])
    @break

    @case('Date of creation')
        @include('tables.components.th-link', ['orderBy' => 'created_at'])
    @break

    @case('Update date')
        @include('tables.components.th-link', ['orderBy' => 'updated_at'])
    @break

    @default
        {{-- Static text --}}
        @include('tables.components.th-unlinked-title')
    @break
@endswitch
