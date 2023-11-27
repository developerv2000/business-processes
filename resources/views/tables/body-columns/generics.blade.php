@switch($column['name'])
    @case('ID')
        {{ $item->id }}
    @break

    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('generics.edit', $item->id)])
    @break

    @case('Created at')
        @include('tables.components.td-date', ['attribute' => 'created_at'])
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->manufacturer->bdm->photo }}" name="{{ $item->manufacturer->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->manufacturer->analyst->photo }}" name="{{ $item->manufacturer->analyst->name }}"></x-other.ava>
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

    @case('Country')
        {{ $item->manufacturer->country->name }}
    @break

    @case('Category')
        <span class="badge badge--green">{{ $item->category->name }}</span>
    @break

    @case('Manufacturer')
        {{ $item->manufacturer->name }}
    @break

    @case('Brand')
        {{ $item->brand }}
    @break

    @case('Generic')
        @include('tables.components.td-limited-text', ['text' => $item->mnn->name])
    @break

    @case('Form')
        {{ $item->form->name }}
    @break

    @case('Root form')
        {{ $item->form->parent ? $item->form->parent->name : $item->form->name }}
    @break

    @case('Dose')
        @include('tables.components.td-limited-text', ['text' => $item->dose])
    @break

    @case('Pack')
        {{ $item->pack }}
    @break

    @case('Processes')
        <a class="td__link td__link--margined" href="{{ route('processes.create') }}?generic_id={{ $item->id }}">{{ __('Add process') }}</a>

        @include('tables.components.td-view-link', [
            'href' => $item->processes_link,
            'text' => __('All processes') . ' ' . $item->untrashed_processes_count,
        ])
    @break

    @case('Minimum volume')
        {{ $item->minimum_volume }}
    @break

    @case('Expiration date')
        {{ $item->expirationDate->limit }}
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

    @case('Additional payment')
        @include('tables.components.td-limited-text', ['text' => $item->additional_payment])
    @break

    @case('Info')
        @include('tables.components.td-limited-text', ['text' => $item->info])
    @break

    @case('Relationships')
        @include('tables.components.td-limited-text', ['text' => $item->relationships])
    @break

    @case('Patent expiry')
        @include('tables.components.td-limited-text', ['text' => $item->patent_expiry])
    @break

    @case('Registered in EU')
        @if ($item->registered_in_eu)
            <span class="badge badge--orange">{{ __('Registered') }}</span>
        @endif
    @break

    @case('Marketed in EU')
        @if ($item->marketed_in_eu)
            <span class="badge badge--blue">{{ __('Marketed') }}</span>
        @endif
    @break

    @case('Last comment')
        @include('tables.components.td-limited-text', ['text' => $item->lastComment?->body])
    @break

    @case('Comment date')
        @if ($item->lastComment)
            <div class="capitalized">
                {{ Carbon\Carbon::parse($item->lastComment->created_at)->isoformat('DD MMM Y') }}
            </div>
        @endif
    @break

    @case('All comments')
        @include('tables.components.td-view-link', [
            'href' => route('comments.generic', $item->id),
            'text' => __('View'),
        ])
    @break

    @default
        <h3>Undefined!</h3>
    @break

@endswitch
