<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('name', 'インスタ風掲示板') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ secure_asset('/css/index.css') }}" type="text/css">
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
       
        <header>

            <div class="nav_top">
             <!--ゲストの場合-->
            @guest
            <ul class="header_nav">
            <li><a href="{{ route('newpage') }}">ログイン</a></li>
            <li><a href="{{ route('register') }}">登録</a></li>
            </ul>
            @else
            <!--ログインしている場合-->
            <ul class="header_nav">
            <li><a href="{{ route('index') }}"><img src="{{ asset('img/home.png') }}" alt="{{ config('name' , 'SNS風ブログ') }}"></a></li>
            <li><a href="{{ route('newpage') }}"><img src="{{ asset('img/purus.png') }}"></a></li>
            <li><a href="{{ route('search') }}"><img src="{{ asset('img/search.png') }}"></a></li>
            <li class="layouts_prof">
             <!--現在ログインしている場合、ログインユーザー画像を表示-->
            @if( Auth::user()->photo )
             <a href="{{ route('user', Auth::user()->id) }}">
                 <!--<img src="{{ asset('storage/profile/' . Auth::user()->profile_photo ) }}">-->
                 <img src="data:image/png;base64,{{ Auth::user()->photo }}"/>
                 </a></li> 
            @else
            <!--ユーザーサンプル画像が表示-->
             <a href="{{ route('user', Auth::user()->id) }}"><img src="{{ asset('img/user_img.png') }}"></a>
            @endif
             </li>
             </ul>
             @endguest
             </div>
         </header>
<div class="content">
 <!--ロゴ表示-->
       <div id="logo">
        <p><img src="{{ asset('img/logo.png') }}"></p>
    </div>
    @yield('main')
</div>
     <footer>
         
         <p class="copy">Copyright © masaki-portfolio-N02</p>
           <div class="footer_nav">
               <!--ゲストの場合-->
            @guest
            <ul class="header_nav">
            <li><a href="{{ route('newpage') }}">ログイン</a></li>
            <li><a href="{{ route('register') }}">登録</a></li>
            </ul>
            <!--ログインしている場合-->
            @else
            <ul class="header_nav">
            <li><a href="{{ route('index') }}"><img src="{{ asset('img/home.png') }}" alt="{{ config('name' , 'SNS風ブログ') }}"></a></li>
            <li><a href="{{ route('newpage') }}"><img src="{{ asset('img/purus.png') }}"></a></li>
            <li><a href="{{ route('search') }}"><img src="{{ asset('img/search.png') }}"></a></li>
            <li class="layouts_prof">
             <!--現在ログインしている場合、ログインユーザー画像があれば表示-->   
            @if( Auth::user()->photo )
             <a href="{{ route('user', Auth::user()->id) }}">
                 <!--<img src="{{ asset('storage/profile/' . Auth::user()->profile_photo ) }}">-->
                 <img src="data:image/png;base64,{{ Auth::user()->photo }}"/>
                 </a></li> 
            @else
            <!--なければユーザーサンプル画像が表示-->
             <a href="{{ route('user', Auth::user()->id) }}"><img src="{{ asset('img/user_img.png') }}"></a>
            @endif
             </li>
             </ul>
             @endguest
             
         </div>      
         
     </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
