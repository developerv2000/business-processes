<h3 class="main-title">{{ __('Similar products') }}</h3>

@if (count($similarProducts))
    <div class="similar-products__list">
        @foreach ($similarProducts as $kvpp)
            <div class="similar-products__list-item">
                <x-other.view-link href="{{ route('kvpp.edit', $kvpp->id) }}" />

                <div class="similar-products__list-text">
                    <span>{{ __('ID') }}: {{ $kvpp->id }}</span>
                    <span>{{ __('Form') }}: {{ $kvpp->form->name }}</span>
                    <span>{{ __('Dosage') }}: {{ $kvpp->dose }}</span>
                    <span>{{ __('Pack') }}: {{ $kvpp->pack }}</span>
                    <span>{{ __('Country') }}: {{ $kvpp->countryCode->name }}</span>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="similar-products__empty-text">{{ __('No similar products found') }}</p>
@endif
