<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-control" content="public, max-age=31536000, immutable">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Styles -->
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet" charset="utf-8">
    {{-- <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet" charset="utf-8"> --}}
    <!--bs4, jq-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="{{ asset('css/admin/Chart.css') }}" media="screen" rel="stylesheet">
</head>

<body>
    <div class="row page-title">
        <h4>{{ config('app.name', 'hello-world') }} Administrator Control Panel</h4>
    </div>
    <div id="app" class="container-fluid row m-0 p-0">
        <nav id="nav_left" class="col-md-3">
            <div id="admin">
                <img src="{{ auth()->user()->profile_photo_path }}" alt="{{ auth()->user()->slug }}" class="rounded-circle">
                <div class="info">
                    <p>Hello, <a href="{{ route('client.user.profile', ['id' => auth()->id()]) }}">{{ auth()->user()->name }}</a></p>
                </div>
            </div>
            <aside id="menu">
                <ul class="d-flex flex-column" aria-orientation="vertical">
                    <li class="item"><a href="{{ route('home') }}" class="nav-link">Trang chủ</a></li>
                    <li class="item {{ \Route::is('admin.view.dashboard') ? 'colorlib-active' : '' }}">
                        <a href="{{ route('admin.view.dashboard') }}" class="nav-link">Dashboard</a>
                    </li>
                    <li class="item {{ (\Route::is('admin.user.index') || \Route::is('admin.user.edit') || \Route::is('admin.user.create') || \Route::is('admin.user.show')) ? 'colorlib-active' : '' }}">
                        <a href="{{ route('admin.user.index') }}" class="nav-link">Thành viên</a>
                    </li>
                    <li class="item {{ (\Route::is('admin.cate.index') || \Route::is('admin.cate.show') || \Route::is('admin.cate.edit') || \Route::is('admin.cate.create')) ? 'colorlib-active' : '' }}">
                        <a href="{{ route('admin.cate.index') }}" class="nav-link">Danh mục</a>
                    </li>
                    <li class="item {{ (\Route::is('admin.post.index') || \Route::is('admin.post.edit') || \Route::is('admin.post.create')) ? 'colorlib-active' : '' }}">
                        <a href="{{ route('admin.post.index') }}" class="nav-link">Bài viết</a>
                    </li>
                    <li class="item">
                        <a class="nav-link" aria-haspopup="true" aria-expanded="false">
                            <i class="metismenu-icon pe-7s-rocket"></i>Trò chuyện
                        </a>
                        <ul class="submenu">
                            @isSuperAdmin
                            <li class="item {{ \Route::is('admin.chat.index') ? 'colorlib-active' : '' }}">
                                <a href="{{ route('admin.chat.index', ['uid' => auth()->id()]) }}" class="nav-link nav-sub-channel">Super Admin Channel</a>
                            </li>
                            @else
                            <li class="item {{ \Route::is('admin.chat.index') ? 'colorlib-active' : '' }}">
                                <a href="{{ route('admin.chat.index', ['uid' => auth()->id()]) }}" class="nav-link nav-sub-channel">Vice Admin Channel</a>
                            </li>
                            @endisSuperAdmin
                        </ul>
                    </li>
                    @can('website.viewAny', auth()->user())
                    <li class="item">
                        <a href="{{ route('admin.site.edit') }}" class="nav-link {{ \Route::is('admin.site.edit') ? 'colorlib-active' : '' }}">Cài đặt</a>
                    </li>
                    @endcan
                    <li class="item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                            {{ __('Đăng xuất') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </aside>
        </nav>
        <main id="main" class="col-md-9 mb-4">
            @yield('content')
        </main>
        <div id="AppendPosition"></div>
    </div>
    <!-- axios-->
    <script src="https://cdn.jsdelivr.net/npm/axios@0.20.0/dist/axios.min.js"></script>
    <!-- pusher -->
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    {{-- <script src="{{ asset('js/nprogress.js') }}" charset="utf-8" defer></script> --}}
    {{-- <script src="{{ asset('js/inputEmoji.js') }}" charset="utf-8" defer></script> --}}
    <script type="text/javascript" src="{{ asset('js/admin/Chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/Chart.min.js') }}"></script>
    <script src="{{ asset('js/admin/app.js') }}" charset="utf-8" defer></script>
    <script src="{{ asset('js/admin/category.js') }}" charset="utf-8" defer></script>
    <script src="{{ asset('js/admin/user.js') }}" charset="utf-8" defer></script>
    <script src="{{ asset('js/admin/post.js') }}" charset="utf-8" defer></script>
    @if (Request::routeIs('admin.chat.index'))
    <script src="{{ asset('js/admin/pusher.js') }}" charset="utf-8" defer></script>
    <script src="{{ asset('js/admin/message.js') }}" charset="utf-8" defer></script>
    @if (auth()->user()->isSuperAdmin())
    <script src="{{ asset('js/admin/superadminchat.js') }}" charset="utf-8" defer></script>
    {{-- <script src="{{ asset('js/admin/ViceAdminChannel.js') }}" charset="utf-8" defer></script> --}}
    @else
    <script src="{{ asset('js/admin/ViceAdminChannel.js') }}" charset="utf-8" defer></script>
    @endif
    @endif
    @yield('script')
</body>

</html>
