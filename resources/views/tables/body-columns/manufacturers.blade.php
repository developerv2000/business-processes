@switch($column['name'])
    @case('ID')
        {{ $item->id }}
    @break

    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('manufacturers.edit', $item->id)])
    @break

    @case('Created at')
        @include('tables.components.td-date', ['attribute' => 'created_at'])
    @break

    @case('Updated at')
        @include('tables.components.td-date', ['attribute' => 'updated_at'])
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

    @case('BDM')
        <x-other.ava image="{{ $item->bdm->photo }}" name="{{ $item->bdm->name }}"></x-other.ava>
    @break

    @case('Analyst')
        <x-other.ava image="{{ $item->analyst->photo }}" name="{{ $item->analyst->name }}"></x-other.ava>
    @break

    @case('Meetings')
        @include('tables.components.td-view-link', [
            'href' => route('meetings.index') . '?manufacturer_id=' . $item->id,
            'text' => __('View')
        ])
    @break

    @case('Country')
        {{ $item->country->name }}
    @break

    @case('Manufacturer')
        {{ $item->name }}
    @break

    @case('Website')
        @include('tables.components.td-limited-text', ['text' => $item->website])
    @break

    @case('Profile')
        @include('tables.components.td-limited-text', ['text' => $item->profile])
    @break

    @case('Relationships')
        @include('tables.components.td-limited-text', ['text' => $item->relationships])
    @break

    @case('Presence')
        <div class="td__limited-text" data-on-click="toggle-text-limit">
            @foreach ($item->presences as $presence)
                {{ $presence->name }}<br>
            @endforeach
        </div>
    @break

    @case('Cooperates')
        @if ($item->cooperates)
            <span class="badge badge--orange">{{ __('Cooperates') }}</span>
        @endif
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

    @case('Zones')
        @foreach ($item->zones as $zone)
            {{ $zone->name }}<br>
        @endforeach
    @break

    @case('Prod/categ')
        <div class="td__categories">
            @foreach ($item->productCategories as $cat)
                <span class="badge badge--green">{{ $cat->name }}</span>
            @endforeach
        </div>
    @break

    @case('Blacklist')
        @foreach ($item->blacklists as $list)
            {{ $list->name }}<br>
        @endforeach
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
            'href' => route('comments.manufacturer', $item->id),
            'text' => __('View')
        ])
    @break

    @default
        <h3>Undefined!</h3>
    @break

@endswitch
