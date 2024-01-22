@switch($column['name'])
    @case('Edit')
        @include('tables.components.td-edit', ['href' => route('kvpp.edit', $item->id)])
    @break

    @case('Status')
        {{ __($item->status->name) }}
    @break

    @case('Country')
        {{ $item->countryCode->name }}
    @break

    @case('Priority')
        <span @class([
            'badge',
            'badge--red' => $item->priority->name == 'A',
            'badge--green' => $item->priority->name == 'B',
            'badge--yellow' => $item->priority->name == 'C',
        ])>
            {{ $item->priority->name }}
        </span>
    @break

    @case('VPS coincidents')
        @foreach ($item->getCoincidentProcesses() as $coincidentProcess)
            <a class="td__link" href="{{ route('processes.index') }}?id={{ $coincidentProcess->id }}" target="_blank">
                # {{ $coincidentProcess->id }} - {{ $coincidentProcess->status->parent->name }}
            </a><br>
        @endforeach
    @break

    @case('IVP coincidents')
        <a class="td__link" href="{{ route('generics.index') }}?mnn_id={{ $item->mnn_id }}&form_id={{ $item->form_id }}" target="_blank">
            {{ $item->getCoincidentGenericsCount() }}
        </a><br>
    @break

    @case('Source')
        {{ $item->source->name }}
    @break

    @case('Generic')
        {{ $item->mnn->name }}
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

    @case('MAH')
        @foreach ($item->promoCompanies as $company)
            {{ $company->name }}<br>
        @endforeach
    @break

    @case('Information')
        @include('tables.components.td-limited-text', ['text' => $item->info])
    @break

    @case('Comments')
        @include('tables.components.td-view-link', [
            'href' => route('comments.kvpp', $item->id),
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

    @case('Date of forecast')
        @include('tables.components.td-date', ['attribute' => 'date_of_forecast'])
    @break

    @case('Forecast 1 year')
        @include('tables.components.td-formatted-price', ['attribute' => 'forecast_year_1'])
    @break

    @case('Forecast 2 year')
        @include('tables.components.td-formatted-price', ['attribute' => 'forecast_year_2'])
    @break

    @case('Forecast 3 year')
        @include('tables.components.td-formatted-price', ['attribute' => 'forecast_year_3'])
    @break

    @case('Portfolio manager')
        {{ $item->portfolioManager?->name }}
    @break

    @case('Analyst')
        @if ($item->analyst)
            <x-other.ava image="{{ $item->analyst->photo }}" name="{{ $item->analyst->name }}"></x-other.ava>
        @endif
    @break

    @case('Date of creation')
        @include('tables.components.td-date', ['attribute' => 'created_at'])
    @break

    @case('Update date')
        @include('tables.components.td-date', ['attribute' => 'updated_at'])
    @break

    @case('ID')
        {{ $item->id }}
    @break

@endswitch
