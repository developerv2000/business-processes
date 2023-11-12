<x-other.modal class="edit-columns-modal" title="{{ __('Setup columns') }}">
    <x-slot:body>
        <form class="edit-columns-form" action="{{ $action }}" method="POST" id="{{ $id }}">
            <p>{{ __('Drag and drop columns for sorting!') }}</p>

            <x-other.sortable-columns :columns="$allColumns" />
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-buttons.hide-modal style="cancel">{{ __('Close') }}</x-buttons.hide-modal>
        <x-form.submit style="main" form="{{ $id }}">{{ __('Update') }}</x-form.submit>
    </x-slot:footer>
</x-other.modal>
