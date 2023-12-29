@switch($column['name'])
    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('generics.edit', $item->id)])
    @break

    @case('Processes')
        <a class="td__link td__link--margined" href="{{ route('processes.create') }}?generic_id={{ $item->id }}">{{ __('Add process') }}</a>

        @include('tables.components.td-view-link', [
            'href' => $item->processes_link,
            'text' => __('All processes') . ' ' . $item->untrashed_processes_count,
        ])
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

    @case('Country')
        {{ $item->manufacturer->country->name }}
    @break

    @case('Manufacturer')
        {{ $item->manufacturer->name }}
    @break

    @case('Manufacturer Brand')
        {{ $item->brand }}
    @break

    @case('Generic')
        @include('tables.components.td-limited-text', ['text' => $item->mnn->name])
    @break

    @case('Form')
        {{ $item->form->name }}
    @break

    @case('Basic form')
        {{ $item->form->parent ? $item->form->parent->name : $item->form->name }}
    @break

    @case('Dosage')
        @include('tables.components.td-limited-text', ['text' => $item->dose])
    @break

    @case('Pack')
        {{ $item->pack }}
    @break

    @case('MOQ')
        {{ $item->minimum_volume }}
    @break

    @case('Shelf Life')
        {{ $item->expirationDate->limit }}
    @break

    @case('Product category')
        <span class="badge badge--green">{{ $item->category->name }}</span>
    @break

    @case('Dossier')
        @include('tables.components.td-limited-text', ['text' => $item->dossier])
    @break

    @case('Zones')
        @foreach ($item->zones as $zone)
            {{ $zone->name }}<br>
        @endforeach
    @break

    @case('Bioequivalence')
        @include('tables.components.td-limited-text', ['text' => $item->bioequivalence])
    @break

    @case('Validity period patent')
        @include('tables.components.td-limited-text', ['text' => $item->patent_expiry])
    @break

    @case('Registered in EU')
        @if ($item->registered_in_eu)
            <span class="badge badge--orange">{{ __('Registered') }}</span>
        @endif
    @break

    @case('Sold in EU')
        @if ($item->marketed_in_eu)
            <span class="badge badge--blue">{{ __('Sold') }}</span>
        @endif
    @break

    @case('Down payment')
        @include('tables.components.td-limited-text', ['text' => $item->additional_payment])
    @break

    @case('Comments')
        @include('tables.components.td-view-link', [
            'href' => route('comments.generic', $item->id),
            'text' => __('View'),
        ])
    @break

    @case('Last comment')
        @include('tables.components.td-limited-text', ['text' => $item->lastComment?->body])
    @break

    @case('Comments Date')
        @if ($item->lastComment)
            <div class="capitalized">
                {{ Carbon\Carbon::parse($item->lastComment->created_at)->isoformat('DD MMM Y') }}
            </div>
        @endif
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
    @break

    @case('Date of creation')
        @include('tables.components.td-date', ['attribute' => 'created_at'])
    @break

    @case('Update Date')
        @include('tables.components.td-date', ['attribute' => 'updated_at'])
    @break

    @case('ID')
        {{ $item->id }}
    @break

@endswitch
