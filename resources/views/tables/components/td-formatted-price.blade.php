@if ($item->{$attribute})
    {{ App\Support\Helper::formatPriceNumber($item->{$attribute}) }}
@endif
