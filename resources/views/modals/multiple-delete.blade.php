<x-other.modal class="multiple-delete-modal" title="{{ __('Delete items') }}">
    <x-slot:body>
        <form class="multiple-delete-form" action="{{ $action }}" method="POST" id="multiple-delete-form">
            @csrf

            @if ($permanently)
                <input type="hidden" name="permanently" value="1">
                <p>{!! __('app.multiple-delete-warning') !!}</p>
                <p>{{ __('app.assosiated-delete-warning') }}</p>
            @else
                <p>{{ __('app.multiple-trash-warning') }}</p>
            @endif
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-buttons.hide-modal style="cancel">{{ __('Cancel') }}</x-buttons.hide-modal>
        <x-form.submit style="danger" form="multiple-delete-form">{{ __('Delete') }}</x-form.submit>
    </x-slot:footer>
</x-other.modal>
