@switch($column['name'])
    @case('ID')
        {{ $item->id }}
    @break

    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('processes.edit', $item->id)])
    @break

    @case('Date')
        @include('tables.components.td-date', ['attribute' => 'status_update_date'])
    @break

    @case('Country')
        {{ $item->countryCode->name }}
    @break

    @case('НПП/УДС')
        <span @class([
            'badge',
            'badge--yellow' => $item->manufacturer->category->name == 'УДС',
            'badge--purple' => $item->manufacturer->category->name == 'НПП',
        ])>
            {{ $item->manufacturer->category->name }}
        </span>
    @break

    @case('Manufacturer')
        {{ $item->manufacturer->name }}
    @break

    @case('Manuf/country')
        {{ $item->manufacturer->country->name }}
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
    @break

    @case('Prod/categ')
        <span class="badge badge--green">{{ $item->generic->category->name }}</span>
    @break

    @case('Generic')
        @include('tables.components.td-limited-text', ['text' => $item->generic->mnn->name])
    @break

    @case('Form')
        {{ $item->generic->form->name }}
    @break

    @case('Dose')
        @include('tables.components.td-limited-text', ['text' => $item->generic->dose])
    @break

    @case('Pack')
        {{ $item->generic->pack }}
    @break

    @case('MAH')
        {{ $item->marketing_authorization_holder }}
    @break

    @case('TM ENG')
        {{ $item->trademark_en }}
    @break

    @case('TM RUS')
        {{ $item->trademark_ru }}
    @break

    @case('Price 1')
        {{ $item->manufacturer_first_offered_price }}
    @break

    @case('Price 2')
        {{ $item->manufacturer_followed_offered_price }}
    @break

    @case('Currency')
        {{ $item->currency?->name }}
    @break

    @case('USD')
        {{ $item->manufacturer_followed_offered_price_in_usd }}
    @break

    @case('Agreed')
        {{ $item->agreed_price }}
    @break

    @case('Our price 2')
        {{ $item->our_followed_offered_price }}
    @break

    @case('Our price 1')
        {{ $item->our_first_offered_price }}
    @break

    @case('Price increased (new price)')
        {{ $item->increased_price }}
    @break

    @case('Price increased %')
        {{ $item->increased_price_percentage }}
    @break

    @case('Price increased date')
        @if ($item->increased_price_date)
            @include('tables.components.td-date', ['attribute' => 'increased_price_date'])
        @endif
    @break

    @case('Expiration date')
        {{ $item->generic->expirationDate->limit }}
    @break

    @case('Minimum volume')
        {{ $item->generic->minimum_volume }}
    @break

    @case('Product link')
        {{ $item->product_link }}
    @break

    @case('Dossier status')
        {{ $item->dossier_status }}
    @break

    @case('Year КИ/БЭ')
        {{ $item->clinical_trial_year }}
    @break

    @case('Countries КИ/БЭ')
        {{ $item->clinical_trial_countries }}
    @break

    @case('ICH country КИ/БЭ')
        {{ $item->clinical_trial_ich_country }}
    @break

    @case('Zones')
        @foreach ($item->generic->zones as $zone)
            {{ $zone->name }}<br>
        @endforeach
    @break

    @case('Additional 1')
        {{ $item->additional_1 }}
    @break

    @case('Additional 2')
        {{ $item->additional_2 }}
    @break

    @case('Status')
        {{ $item->status->name }}
    @break

    @case('General status')
        {{ $item->status->parent->name }}
    @break

    @case('ПО date')
        @if ($item->stage_2_start_date)
            @include('tables.components.td-date', ['attribute' => 'stage_2_start_date'])
        @endif
    @break

    @case('Year 1')
        {{ $item->year_1 }}
    @break

    @case('Year 2')
        {{ $item->year_2 }}
    @break

    @case('Year 3')
        {{ $item->year_3 }}
    @break

    @case('Owners')
        @foreach ($item->owners as $owner)
            {{ $owner->name }}<br>
        @endforeach
    @break

    @case('Process date')
        @include('tables.components.td-date', ['attribute' => 'date'])
    @break

    @case('Days past')
        {{ $item->days_past }}
    @break

    @default
        <h3>Undefined!</h3>
    @break

@endswitch
