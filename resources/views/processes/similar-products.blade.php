<h3 class="main-title">{{ __('Similar products') }}</h3>

@if (count($similarProducts))
    <div class="similar-products__list">
        @foreach ($similarProducts as $generic)
            <div class="similar-products__list-item">
                <x-other.view-link href="{{ route('generics.edit', $generic->id) }}" />

                <div class="similar-products__list-text">
                    <span>{{ __('ID') }}: {{ $generic->id }}</span>
                    <span>{{ __('Form') }}: {{ $generic->form->name }}</span>
                    <span>{{ __('Dose') }}: {{ $generic->dose }}</span>
                    <span>{{ __('Pack') }}: {{ $generic->pack }}</span>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="similar-products__empty-text">{{ __('No similar products found') }}</p>
@endif
