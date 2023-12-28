@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Links --}}
    @case('Status')
        @include('tables.components.th-link', ['orderBy' => 'status_id'])
    @break

    @case('Country')
        @include('tables.components.th-link', ['orderBy' => 'country_code_id'])
    @break

    @case('Priority')
        @include('tables.components.th-link', ['orderBy' => 'priority_id'])
    @break

    @case('Source')
        @include('tables.components.th-link', ['orderBy' => 'source_id'])
    @break

    @case('MAH')
        @include('tables.components.th-link', ['orderBy' => 'promo_company_id'])
    @break

    @case('Date of forecast')
        @include('tables.components.th-link', ['orderBy' => 'date_of_forecast'])
    @break

    @case('Portfolio manager')
        @include('tables.components.th-link', ['orderBy' => 'portfolio_manager_id'])
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
