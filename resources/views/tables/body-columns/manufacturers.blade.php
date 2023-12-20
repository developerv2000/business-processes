@switch($column['name'])
    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('manufacturers.edit', $item->id)])
    @break

    @case('BDM')
        <x-other.ava image="{{ $item->bdm->photo }}" name="{{ $item->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->analyst->photo }}" name="{{ $item->analyst->name }}"></x-other.ava>
    @break

    @case('Country')
        {{ $item->country->name }}
    @break

    @case('Manufacturer')
        {{ $item->name }}
    @break

    @case('Category')
        <span @class([
            'badge',
            'badge--yellow' => $item->category->name == 'УДС',
            'badge--purple' => $item->category->name == 'НПП',
        ])>
            {{ $item->category->name }}
        </span>
    @break

    @case('Status')
        @if ($item->active)
            <span class="badge badge--blue">{{ __('Active') }}</span>
        @else
            <span class="badge badge--grey">{{ __('Stoped') }}</span>
        @endif
    @break

    @case('Important')
        @if ($item->important)
            <span class="badge badge--red">{{ __('Important') }}</span>
        @endif
    @break

    @case('Product category')
        <div class="td__categories">
            @foreach ($item->productCategories as $cat)
                <span class="badge badge--green">{{ $cat->name }}</span>
            @endforeach
        </div>
    @break

    @case('Zones')
        @foreach ($item->zones as $zone)
            {{ $zone->name }}<br>
        @endforeach
    @break

    @case('Black list')
        @foreach ($item->blacklists as $list)
            {{ $list->name }}<br>
        @endforeach
    @break

    @case('Presence')
        <div class="td__limited-text" data-on-click="toggle-text-limit">
            @foreach ($item->presences as $presence)
                {{ $presence->name }}<br>
            @endforeach
        </div>
    @break

    @case('Website')
        @include('tables.components.td-limited-text', ['text' => $item->website])
    @break

    @case('About company')
        @include('tables.components.td-limited-text', ['text' => $item->profile])
    @break

    @case('Relationship')
        @include('tables.components.td-limited-text', ['text' => $item->relationships])
    @break

    @case('Comments')
        @include('tables.components.td-view-link', [
            'href' => route('comments.manufacturer', $item->id),
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

    @case('Date of creation')
        @include('tables.components.td-date', ['attribute' => 'created_at'])
    @break

    @case('Update Date')
        @include('tables.components.td-date', ['attribute' => 'updated_at'])
    @break

    @case('Meetings')
        @include('tables.components.td-view-link', [
            'href' => route('meetings.index') . '?manufacturer_id=' . $item->id,
            'text' => __('View'),
        ])
    @break

    @case('ID')
        {{ $item->id }}
    @break

@endswitch
