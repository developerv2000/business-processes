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
    @case('MAH')
    @case('TM ENG')
    @case('TM RUS')
    @case('Price 1')
    @case('Price 2')
    @case('Currency')
    @case('USD')
    @case('Agreed')
    @case('Our price 2')
    @case('Our price 1')
    @case('Price increased (new price)')
    @case('Price increased %')
    @case('Price increased date')
    @case('Expiration date')
    @case('Minimum value')
    @case('Product link')
    @case('Dossier status')
    @case('Year КИ/БЭ')
    @case('Сountries КИ/БЭ')
    @case('ICH country КИ/БЭ')
    @case('Zones')
    @case('Additional 1')
    @case('Additional 2')
    @case('General status')
    @case('Year 1')
    @case('Year 2')
    @case('Year 3')
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

    @case('ПО date')
        @include('tables.components.th-link', ['orderBy' => 'stage_2_start_date'])
    @break

    @case('Process date')
        @include('tables.components.th-link', ['orderBy' => 'date'])
    @break

    @default
        <h3>Undefined!</h3>
    @break
@endswitch
