@extends('layouts.app', ['class' => 'kpe-index x-overflowed'])

@section('main')
    <div class="kpe-index__first-box styled-box">
        @include('tables.index-pages.kpe')
    </div>
@endsection
