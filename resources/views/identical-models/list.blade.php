@extends('layouts.app', ['class' => 'identical-models-list rightbarless'])

@section('main')
    <div class="identical-models-list__box styled-box">
        <div class="prehead">
            @include('layouts.breadcrumbs', [
                'crumbs' => [__('Different')],
                'fullScreen' => false,
            ])
        </div>

        <div class="table-wrapper thin-scrollbar">
            <table class="table">
                {{-- Head start --}}
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Items') }}</th>
                    </tr>
                </thead> {{-- Head end --}}

                {{-- Body Start --}}
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <a class="td__link" href="{{ route('identical-models.index', $item['name']) }}">{{ $item['name'] }}</a>
                            </td>

                            <td>{{ $item['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody> {{-- Body end --}}
            </table>

        </div>
    </div>
@endsection
