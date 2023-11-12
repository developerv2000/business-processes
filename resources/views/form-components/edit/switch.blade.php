<x-form.group class="form-group--horizontal form-group--reversed" label="{{ __($label) }}">
    <input class="switch" type="checkbox" name="{{ $attribute }}" value="1" @checked($item->{$attribute})>
</x-form.group>
