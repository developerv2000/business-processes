@if ($fullScreen)
    <span class="material-symbols-outlined prehead__fullscreen" title="{{ __('Full screen mode') }}" data-click-action="request-fullscreen" data-element-target=".inner-wrapper">fullscreen</span>
@endif

<ul class="breadcrumbs">
    @foreach ($crumbs as $crumb)
        <li class="breadcrumbs__item">{!! $crumb !!}</li>
    @endforeach
</ul>
