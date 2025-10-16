<div class="d-flex">
    <div class="nav-item dropdown d-flex me-3">
        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications"
            aria-expanded="false">
            <!-- Download SVG icon from http://tabler.io/icons/icon/bell -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-1">
                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
            </svg>
            @if ($notifications->whereNull('read_at')->count() > 0)
                <span class="badge bg-red"></span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card" data-bs-popper="static" style="min-width: 300px">
            <div class="card">
                <div class="card-header p-2">
                    <h3 class="card-title">@lang('Thông báo')</h3>
                </div>
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
                <div class="card-footer p-1 text-center">
                    <a href="{{ route('notification.notification.index') }}">@lang('Xem tất cả')</a>
                </div>
            </div>
        </div>
    </div>
</div>
