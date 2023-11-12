<x-other.modal class="single-delete-modal" title="{{ __('Delete items') }}">
    <x-slot:body>
        <form class="single-delete-form" action="{{ $action }}" method="POST" id="single-delete-form">
            @csrf

            {{-- Almost everywhere items deleted through loop, thats why array is used --}}
            <input type="hidden" name="ids[]" value="{{ $item->id }}">

            @if ($permanently)
                <input type="hidden" name="permanently" value="1">
                <p>{!! __('app.single-delete-warning') !!}</p>
                <p>{{ __('app.assosiated-delete-warning') }}</p>
            @else
                <p>{{ __('app.single-trash-warning') }}</p>
            @endif
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-buttons.hide-modal style="cancel">{{ __('Cancel') }}</x-buttons.hide-modal>
        <x-form.submit style="danger" form="single-delete-form">{{ __('Delete') }}</x-form.submit>
    </x-slot:footer>
</x-other.modal>
