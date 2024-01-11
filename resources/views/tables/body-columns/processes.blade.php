@switch($column['name'])
    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('processes.edit', $item->id)])
    @break

    @case('Date')
        @include('tables.components.td-date', ['attribute' => 'status_update_date'])
    @break

    @case('Search country')
        {{ $item->countryCode->name }}
    @break

    @case('Product status')
        {{ $item->status->name }}
    @break

    @case('Category')
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

    @case('Country of manufacturer')
        {{ $item->manufacturer->country->name }}
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
    @break

    @case('Generic')
        @include('tables.components.td-limited-text', ['text' => $item->generic->mnn->name])
    @break

    @case('Form')
        {{ $item->generic->form->name }}
    @break

    @case('Dosage')
        @include('tables.components.td-limited-text', ['text' => $item->generic->dose])
    @break

    @case('Pack')
        {{ $item->generic->pack }}
    @break

    @case('MAH')
        {{ $item->promoCompany?->name }}
    @break

    @case('General status')
        {{ $item->status->parent->name }}
    @break

    @case('Comments')
        @include('tables.components.td-view-link', [
            'href' => route('comments.process', $item->id),
            'text' => __('View'),
        ])
    @break

    @case('Last comment')
        @include('tables.components.td-limited-text', ['text' => $item->lastComment?->body])
    @break

    @case('Comments date')
        @if ($item->lastComment)
            <div class="capitalized">
                {{ Carbon\Carbon::parse($item->lastComment->created_at)->isoformat('DD MMM Y') }}
            </div>
        @endif
    @break

    @case('Manufacturer price 1')
        {{ $item->manufacturer_first_offered_price }}
    @break

    @case('Manufacturer price 2')
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

    @case('Price increased new price')
        {{ $item->increased_price }}
    @break

    @case('Price increased by%')
        {{ $item->increased_price_percentage }} @if ($item->increased_price_percentage)
            %
        @endif
    @break

    @case('Date of price increased')
        @if ($item->increased_price_date)
            @include('tables.components.td-date', ['attribute' => 'increased_price_date'])
        @endif
    @break

    @case('Shelf life')
        {{ $item->generic->expirationDate->limit }}
    @break

    @case('MOQ')
        {{ $item->generic->minimum_volume }}
    @break

    @case('Dossier status')
        {{ $item->dossier_status }}
    @break

    @case('Year Cr/Be')
        {{ $item->clinical_trial_year }}
    @break

    @case('Countries Cr/Be')
        @foreach ($item->crbeCountries as $country)
            {{ $country->name }}<br>
        @endforeach
    @break

    @case('Country ich')
        {{ $item->clinical_trial_ich_country }}
    @break

    @case('Zones')
        @foreach ($item->generic->zones as $zone)
            {{ $zone->name }}<br>
        @endforeach
    @break

    @case('Down payment 1')
        {{ $item->additional_1 }}
    @break

    @case('Down payment 2')
        {{ $item->additional_2 }}
    @break

    @case('Date of forecast')
        @if ($item->stage_2_start_date)
            @include('tables.components.td-date', ['attribute' => 'stage_2_start_date'])
        @endif
    @break

    @case('Forecast 1 year')
        @include('tables.components.td-formatted-price', ['attribute' => 'year_1'])
    @break

    @case('Forecast 2 year')
        @include('tables.components.td-formatted-price', ['attribute' => 'year_2'])
    @break

    @case('Forecast 3 year')
        @include('tables.components.td-formatted-price', ['attribute' => 'year_3'])
    @break

    @case('Responsible')
        @foreach ($item->owners as $owner)
            {{ $owner->name }}<br>
        @endforeach
    @break

    @case('Process date')
        @include('tables.components.td-date', ['attribute' => 'date'])
    @break

    @case('Days have passed!')
        {{ $item->days_past }}
    @break

    @case('Brand Eng')
        {{ $item->trademark_en }}
    @break

    @case('Brand Rus')
        {{ $item->trademark_ru }}
    @break

    @case('Date of creation')
        @include('tables.components.td-date', ['attribute' => 'created_at'])
    @break

    @case('Update date')
        @include('tables.components.td-date', ['attribute' => 'updated_at'])
    @break

    @case('Product category')
        <span class="badge badge--green">{{ $item->generic->category->name }}</span>
    @break

    @case('ID')
        {{ $item->id }}
    @break

@endswitch
