<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('img/main/favicon.png') }}">

    <title>{{ __('Business processes') }}</title>

    {{-- Selectize --}}
    <link rel="stylesheet" href="{{ asset('plugins/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/selectize/selectize.css') }}">

    {{-- JQuery DateRangePicker --}}
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    {{-- Simditor v2.3.28 --}}
    <link rel="stylesheet" href="{{ asset('plugins/simditor/simditor.css') }}">

    {{-- Styles --}}
    @vite('resources/css/app.css')
</head>

<body class="{{ $class }}">
    <div class="main-wrapper @if (request()->user()->settings['fullWidth']) main-wrapper--expanded @endif">
        @include('layouts.header')

        <div class="inner-wrapper">
            @include('layouts.leftbar')

            <main class="main">
                @yield('main')
                <x-other.spinner />
            </main>

            @hasSection('rightbar')
                @yield('rightbar')
            @endif
        </div>
    </div>

    {{-- JQuery --}}
    <script src="{{ asset('plugins/jquery/jquery-3.6.4.min.js') }}"></script>

    {{-- JQuery UI --}}
    <script src="{{ asset('plugins/jquery/jquery-ui.min.js') }}"></script>

    {{-- Moment.js (for DateRangePicker) --}}
    <script src="{{ asset('plugins/moment.min.js') }}"></script>

    {{-- JQuery DateRangePicker --}}
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.min.js') }}"></script>

    {{-- Selectize --}}
    <script src="{{ asset('plugins/selectize/selectize.min.js') }}"></script>

    {{-- JQ Nested Set --}}
    <script src="{{ asset('plugins/jq-nested/jq-nested-sortable.js') }}"></script>

    {{-- Simditor v2.3.28 --}}
    <script src="{{ asset('plugins/simditor/module.js') }}"></script>
    <script src="{{ asset('plugins/simditor/hotkeys.js') }}"></script>
    <script src="{{ asset('plugins/simditor/uploader.js') }}"></script>
    <script src="{{ asset('plugins/simditor/simditor.js') }}"></script>

    {{-- Scripts --}}
    @vite('resources/js/app.js')
</body>

</html>
