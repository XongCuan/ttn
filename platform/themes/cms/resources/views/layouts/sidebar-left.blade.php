<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('dashboard.index') }}">
                <img src="{{ asset($logo) }}" width="100px" height="auto" alt="Logo site" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            @include('themes_cms::layouts.notification')
        </div>
        <div class="navbar-collapse collapse" id="sidebar-menu" style="">
            <ul class="navbar-nav pt-lg-3">
                @foreach ($sidebarData->getMenu() as $item)
                    @if ($sidebarData->visiable($item))
                        @if ($sidebarData->isHeader($item))
                            <li @class(['nav-header'])>@lang($item['title'])</li>
                        @else
                            <li @class(['nav-item', 'dropdown' => $sidebarData->hasSub($item)])>
                                <a @class([
                                    'nav-link', 'dropdown-toggle' => $sidebarData->hasSub($item)
                                ])
                                    href="{{ $sidebarData->getUrl($item) }}" 
                                    @if($sidebarData->hasSub($item)) 
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="false" 
                                        role="button" 
                                        aria-expanded="false"
                                    @endif
                                >
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        {!! $item['icon'] ?? '' !!}
                                    </span>
                                    <span class="nav-link-title">@lang($item['title'])</span>
                                </a>
                                @if ($sidebarData->hasSub($item))
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                @foreach ($item['sub'] as $item)
                                                    @if($sidebarData->visiable($item))
                                                        <a class="dropdown-item" href="{{ $sidebarData->getUrl($item) }}">
                                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                {!! $item['icon'] ?? '' !!}
                                                            </span>
                                                            <span class="nav-link-title">@lang($item['title'])</span>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>

