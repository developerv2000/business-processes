@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Static text --}}
    @case('BDM')
    @case('Analyst')
    @case('НПП/УДС')
    @case('Country')
    @case('Category')
    @case('Dose')
    @case('Pack')
    @case('Processes')
    @case('Minimum volume')
    @case('Dossier')
    @case('Zones')
    @case('Relationships')
    @case('Bioequivalence')
    @case('Info')
    @case('Root form')
    @case('Patent expiry')
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

    @case('Manufacturer')
        @include('tables.components.th-link', ['orderBy' => 'manufacturer_id'])
    @break

    @case('Brand')
        @include('tables.components.th-link', ['orderBy' => 'brand'])
    @break

    @case('Generic')
        @include('tables.components.th-link', ['orderBy' => 'mnn_id'])
    @break

    @case('Form')
        @include('tables.components.th-link', ['orderBy' => 'form_id'])
    @break

    @case('Expiration date')
        @include('tables.components.th-link', ['orderBy' => 'expiration_date_id'])
    @break

    @case('Additional payment')
        @include('tables.components.th-link', ['orderBy' => 'additional_payment'])
    @break

    @case('Registered in EU')
        @include('tables.components.th-link', ['orderBy' => 'registered_in_eu'])
    @break

    @case('Marketed in EU')
        @include('tables.components.th-link', ['orderBy' => 'marketed_in_eu'])
    @break

    @default
        <h3>Undefined!</h3>
    @break
@endswitch
