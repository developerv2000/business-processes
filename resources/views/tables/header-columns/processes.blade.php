@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Static text --}}
    @case('НПП/УДС')
    @case('Manufacturer')
    @case('Manuf/country')
    @case('BDM')
    @case('Analyst')
    @case('Prod/categ')
    @case('Generic')
    @case('Form')
    @case('Dose')
    @case('Pack')
    @case('General status')
    @case('Owners')
    @case('Days past')
        @include('tables.components.th-unlinked-title')
    @break

    {{-- Links --}}
    @case('ID')
        @include('tables.components.th-link', ['orderBy' => 'id'])
    @break

    @case('Date')
        @include('tables.components.th-link', ['orderBy' => 'status_update_date'])
    @break

    @case('Country')
        @include('tables.components.th-link', ['orderBy' => 'country_code_id'])
    @break

    @case('Status')
        @include('tables.components.th-link', ['orderBy' => 'status_id'])
    @break

    @case('Process date')
        @include('tables.components.th-link', ['orderBy' => 'date'])
    @break

    @default
        <h3>Undefined!</h3>
    @break
@endswitch
