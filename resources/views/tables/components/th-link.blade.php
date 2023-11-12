<a class="{{ $params['orderType'] }} @if($params['orderBy'] == $orderBy) active @endif"
    href="{{ $params['newOrderUrl'] . '&orderBy=' . $orderBy }}">
    <span>{{ __($column['name']) }}</span>
    <span class="material-symbols-outlined">expand_all</span>
</a>
