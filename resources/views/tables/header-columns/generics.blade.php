@switch($column['name'])
    {{-- Edit --}}
    @case('Edit')
        @include('tables.components.th-edit')
    @break

    {{-- Links --}}
    @case('Manufacturer')
        @include('tables.components.th-link', ['orderBy' => 'manufacturer_id'])
    @break

    @case('Manufacturer Brand')
        @include('tables.components.th-link', ['orderBy' => 'brand'])
    @break

    @case('Generic')
        @include('tables.components.th-link', ['orderBy' => 'mnn_id'])
    @break

    @case('Form')
        @include('tables.components.th-link', ['orderBy' => 'form_id'])
    @break

    @case('Shelf Life')
        @include('tables.components.th-link', ['orderBy' => 'expiration_date_id'])
    @break

    @case('Down payment')
        @include('tables.components.th-link', ['orderBy' => 'additional_payment'])
    @break

    @case('Registered in EU')
        @include('tables.components.th-link', ['orderBy' => 'registered_in_eu'])
    @break

    @case('Sold in EU')
        @include('tables.components.th-link', ['orderBy' => 'marketed_in_eu'])
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
