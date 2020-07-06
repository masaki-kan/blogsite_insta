<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('name', 'SNS風ブログ') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ secure_asset('/css/index.css') }}" type="text/css">
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
        <header>
            @guest
            <p><a href="{{ route('index') }}">{{ config('name' , 'サンプルSNS') }}</a></p>
            <p><a href="{{ route('newpage') }}">ログイン</a></p>
            <p><a href="{{ route('register') }}">登録</a></p>
            @else
            
            <p><a href="{{ route('index') }}">SNS</a></p>
            <p><a href="{{ route('newpage') }}">投稿</a></p>
            
            <p class="layouts_prof">
            @if( Auth::user()->profile_photo )
               <a href="{{ route('user', Auth::user()->id) }}"><img src="{{ asset('storage/profile/' . Auth::user()->profile_photo ) }}"></a> 
            @else
             <a href="{{ route('user', Auth::user()->id) }}"><img src="{{ asset('img/user_img.png') }}"></a>
            @endif
             </p>
             
            <p>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            </p>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            { csrf_field() }}
        </form>
             @endguest
         </header>

        @yield('main')
    <footer>
        <div class="pc_nav">
        <ul class="footer_menu">
            <li>ホーム</li>
            <li><a href="{{ route('newpage') }}">投稿</a></li>
            </li>
        </ul>
        </div>
        <div class="mobile_nav">
       </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
