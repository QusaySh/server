<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <meta property="og:url"           content="https://<?php echo $_SERVER['HTTP_HOST'] . "/send_message"; ?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="تكلم عني بصدق" />
    <meta property="og:description"   content="موقع تكلم بصدق يهدف الى جعل الناس يتكلمون عنك بصدق دون معرفة الشخص المتكلم وذلك لتقبل الكلام و من غير زعل من ذلك الشخص وليتكلم بشجاعة عنك." />
    <meta property="og:image"         content="{{ asset('images/a.jpg') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'الصفحة الرئيسية')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-grid-rtl.css') }}" rel="stylesheet">

    {{-- font awesome --}}
    
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.magnify.min.css') }}" rel="stylesheet">

    {{-- my style --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="mt-5">
    
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-10 mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#search" href="{{ route('register') }}">{{ __('البحث') }} <i class="fa fa-search fa-fw"></i></a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in fa-fw"></i> {{ __('تسجيل الدخول') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-user-plus fa-fw"></i> {{ __('إنشاء حساب') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ __('التحكم') }}
                        </a>
    
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if ( Auth::user()->admin )
                                <a class="dropdown-item" href="{{ route('admin.index') }}">
                                    <i class="fa fa-dashboard fa-fw"></i> {{ __('لوحة التحكم') }}
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fa fa-user fa-fw"></i> {{ __('ملفي الشخصي') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out fa-fw"></i> {{ __('تسجيل الخروج') }}
                            </a>
    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                  </ul>
                </div>
            </div>
        </nav>

        {{-- Search --}}
        <div class="modal fade" id="search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">البحث عن إسم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('search') }}" method="GET">
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label for="input_search">البحث:</label>
                                <input type="search" name="search" class="form-control" id="input_search" placeholder="اكتب الإسم المراد البحث عنه">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-outline-info" >بحث</button>
                    </div>
            </form>
            </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/cookie.js') }}"></script>
    <script src="{{ asset('js/jquery.magnify.min.js') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
