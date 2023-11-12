<x-other.modal class="delete-target-modal" title="{{ __('Delete items') }}">
    <x-slot:body>
        <form class="delete-target-form" action="{{ $action }}" method="POST" id="delete-target-form">
            @csrf

            {{-- Almost everywhere items deleted through loop, thats why array is used
                Input value changes on delete button click --}}
            <input type="hidden" name="ids[]">

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
        <x-form.submit style="danger" form="delete-target-form">{{ __('Delete') }}</x-form.submit>
    </x-slot:footer>
</x-other.modal>
