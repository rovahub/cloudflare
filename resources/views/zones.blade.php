@extends('cloudflare::layouts.master')
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('cloudflare::zone.domain') }}</th>
            <th>{{ __('cloudflare::zone.registrar') }}</th>
            <th>{{ __('cloudflare::zone.created_on') }}</th>
            <th>{{ __('cloudflare::zone.status') }}</th>
            <th>CLOUDFLARE</th>
            <th width="15%">{{ __('cloudflare::zone.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($zones as $key => $zone)
            <tr>
                <td>
                    <a class="alert-link" href="{{ route('cloudflare:zone.index') }}">{{ $zone->name }}</a>
                </td>
                <td>
                    <code>
                        @if($zone->original_registrar)
                            {{ $zone->original_registrar }}
                        @else
                            {{ __('cloudflare::zone.unknown') }}
                        @endif
                    </code>
                </td>
                <td>{{ Carbon\Carbon::parse($zone->created_on)->format('d/m/Y') }}</td>
                <td>
                    @if($zone->status === 'active')
                        <span class="text-success">
                            <i class="fa-solid fa-circle-check"></i> {{ __('cloudflare::zone.active') }}
                        </span>
                    @else
                        <span class="text-warning">
                            <i class="fa-solid fa-circle-check"></i> {{ __('cloudflare::zone.inactive') }}
                        </span>
                    @endif
                </td>
                <td>
                    @if(!$zone->paused)
                        <span onclick="changeProxies('{{ $zone->name }}', '{{ $zone->paused }}', '{{ $zone->id }}')" class="d-flex align-items-center"
                              style="cursor: pointer;">
                            <i class="fa-brands fa-cloudflare fs-3 text-warning me-2"></i>
                            {{ __('cloudflare::zone.enabled') }}
                        </span>
                    @else
                        <span onclick="changeProxies('{{ $zone->name }}', '{{ $zone->paused }}', '{{ $zone->id }}')"
                              class="d-flex align-items-center text-secondary" style="cursor: pointer;">
                            <i class="fa-brands fa-cloudflare fs-3 me-2"></i>
                            {{ __('cloudflare::zone.disabled') }}
                        </span>
                    @endif
                </td>
                <td class="list-act">
                    <a class="btn btn-primary btn-sm" title="Quản lý DNS">
                        <i class="fas fa-globe"></i> DNS
                    </a>
                    <button onclick="deleteCache('{{ $zone->name }}','{{ $zone->id }}')" data-domain="{{ $zone->name }}"
                            class="btn btn-danger btn-sm" title="Xoá cache">
                        <i class="fas fa-eraser"></i> Cache
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/cloudflare/zone.css') }}">
@endsection
@section('scripts')
    <script>
        function deleteCache(domain, id) {
            $.confirm({
                title: `{{__('cloudflare::zone.delete_cache_title')}} ${domain}`,
                content: '{{__('cloudflare::zone.delete_cache_content')}}',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '{{ __('cloudflare::zone.delete') }}',
                        btnClass: 'btn-red',
                        action: function () {
                            $.ajax({
                                method: 'PUT',
                                url: '{{ route('cloudflare:zone.cache') }}',
                                data: {
                                    domain,
                                    id
                                },
                                success: () => {
                                    $.alert('Deleted the user!');
                                },
                                error: () => {
                                    $.alert('Deleted the user!');
                                }
                            })
                        }
                    },
                    close: {
                        text: '{{ __('cloudflare::zone.close') }}'
                    }
                }
            });
        }

        function changeProxies(domain, pause, id) {
            $.confirm({
                title: !pause ? `{{__('cloudflare::zone.pause_cloudflare_title')}} ${domain}` : '{{__('cloudflare::zone.enable_cloudflare')}}',
                content: !pause ? '{{__('cloudflare::zone.pause_cloudflare_content')}}' : '',
                type: 'info',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '{{ __('cloudflare::zone.confirm') }}',
                        btnClass: 'btn-red',
                        action: function () {
                            $.ajax({
                                method: 'PUT',
                                url: '{{ route('cloudflare:zone.proxies') }}',
                                data: {
                                    domain,
                                    pause,
                                    id
                                },
                                success: () => {
                                    $.alert('Deleted the user!');
                                },
                                error: () => {
                                    $.alert('Deleted the user!');
                                }
                            })
                        }
                    },
                    close: {
                        text: '{{ __('cloudflare::zone.close') }}',
                        action: function () {
                        }
                    }
                }
            });
        }
    </script>
@endsection
