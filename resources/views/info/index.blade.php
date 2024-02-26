@extends('layouts.app', ['class' => 'info-index rightbarless'])

@section('main')
    <div class="info-index__box">
        <div class="prehead prehead--intended styled-box">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Info')],
                'fullScreen' => false,
            ])
        </div>

        <div class="info-index__blocks styled-box">
            @foreach ($blocks as $block)
                <div class="info-index__block-item">
                    @if ($block->is_collapse)
                        <x-other.collapse title="{{ $block->name }}">
                            {!! $block->content !!}

                            @if (count($block->children))
                                @include('info.child', ['children' => $block->children])
                            @endif
                        </x-other.collapse>
                    @else
                        {!! $block->content !!}
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
