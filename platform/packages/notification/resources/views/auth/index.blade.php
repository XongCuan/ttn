@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header fs-3 p-3">@lang('Thông báo')</div>
                        <div class="list-group list-group-flush list-group-hoverable">
                            @forelse ($notifications as $notification)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span @class(["status-dot d-block", "status-dot-animated bg-red" => $notification->read_at == null])></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="{{ route('notification.notification.show', $notification->id) }}" class="text-body d-block">{{ $notification->data['title'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-auto text-center">
                                            <img src="{{ asset('/public/images/norecord.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="card-footer">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
