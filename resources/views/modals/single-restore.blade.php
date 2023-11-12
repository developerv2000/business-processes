<x-other.modal class="single-restore-modal" title="{{ __('Restore item') }}">
    <x-slot:body>
        <form class="single-restore-form" action="{{ $action }}" method="POST" id="single-restore-form">
            @csrf

            <input type="hidden" name="ids[]">
            <p>{{ __('Restore item') }}?</p>
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-buttons.hide-modal style="cancel">{{ __('Cancel') }}</x-buttons.hide-modal>
        <x-form.submit style="success" form="single-restore-form">{{ __('Restore') }}</x-form.submit>
    </x-slot:footer>
</x-other.modal>
