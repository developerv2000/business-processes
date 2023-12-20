@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Links --}}
    @case('BDM')
        @include('tables.components.th-link', ['orderBy' => 'bdm_user_id'])
    @break

    @case('Analyst')
        @include('tables.components.th-link', ['orderBy' => 'analyst_user_id'])
    @break

    @case('Country')
        @include('tables.components.th-link', ['orderBy' => 'country_id'])
    @break

    @case('Manufacturer')
        @include('tables.components.th-link', ['orderBy' => 'name'])
    @break

    @case('Category')
        @include('tables.components.th-link', ['orderBy' => 'category_id'])
    @break

    @case('Status')
        @include('tables.components.th-link', ['orderBy' => 'active'])
    @break

    @case('Important')
        @include('tables.components.th-link', ['orderBy' => 'important'])
    @break

    @case('Date of creation')
        @include('tables.components.th-link', ['orderBy' => 'created_at'])
    @break

    @case('Update Date')
        @include('tables.components.th-link', ['orderBy' => 'updated_at'])
    @break

    @default
        {{-- Static text --}}
        @include('tables.components.th-unlinked-title')
    @break
@endswitch
