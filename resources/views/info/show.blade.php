@extends('layouts.app', ['class' => 'info-show rightbarless'])

@section('main')
    <div class="info-show__box">
        <div class="prehead prehead--intended styled-box">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Info')],
                'fullScreen' => false,
            ])
        </div>

        <div class="info-show__blocks styled-box">
            @foreach ($blocks as $block)
                <div class="info-show__block-item">
                    {{-- Collapse --}}
                    @if ($block->is_collapse)
                        <x-other.collapse title="{{ $block->name }}">
                            {!! $block->content !!}

                            @if (count($block->children))
                                @include('info.child-block', ['children' => $block->children])
                            @endif
                        </x-other.collapse>
                    {{-- Non collapse --}}
                    @else
                        {!! $block->content !!}

                        @if (count($block->children))
                            @include('info.child-block', ['children' => $block->children])
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
