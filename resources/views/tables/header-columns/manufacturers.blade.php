@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Static text --}}
    @case('Meetings')
    @case('Profile')
    @case('Relationships')
    @case('Presence')
    @case('Zones')
    @case('Prod/categ')
    @case('Blacklist')
    @case('Last comment')
    @case('Comment date')
    @case('All comments')
        @include('tables.components.th-unlinked-title')
    @break

    {{-- Links --}}
    @case('ID')
        @include('tables.components.th-link', ['orderBy' => 'id'])
    @break

    @case('Created at')
        @include('tables.components.th-link', ['orderBy' => 'created_at'])
    @break

    @case('Updated at')
        @include('tables.components.th-link', ['orderBy' => 'updated_at'])
    @break

    @case('Category')
        @include('tables.components.th-link', ['orderBy' => 'category_id'])
    @break

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

    @case('Website')
        @include('tables.components.th-link', ['orderBy' => 'website'])
    @break

    @case('Cooperates')
        @include('tables.components.th-link', ['orderBy' => 'cooperates'])
    @break

    @case('Status')
        @include('tables.components.th-link', ['orderBy' => 'active'])
    @break

    @case('Important')
        @include('tables.components.th-link', ['orderBy' => 'important'])
    @break

    @default
        <h3>Undefined!</h3>
    @break
@endswitch
