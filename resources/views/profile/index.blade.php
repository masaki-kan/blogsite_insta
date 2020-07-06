@extends('layouts.header')

@section('main')
<div class="prof_sec">
    <h2>プロフィール</h2>
<div class="prof_content">
    
    <!--ユーザー画像表示-->
    <div class="prof_userimage">
    @if( $user->photo )
    <p>
        <!--<img src="{{ asset('storage/profile/' . $user->profile_photo ) }}">-->
        <img src="data:image/png;base64,{{ $user->photo }}"/>
        </p>
    @else
    <!--ユーザー画像がなければサンプル画像-->
    <p class="img"><img src="{{ asset('img/user_img.png') }}"></p>
    @endif
    </div>
    
    <div class="prof_data">
    <h3>ユーザー</h3>
    <p>{{ $user->name }}</p>
    <p>{{ $user->email }}</p>
    @guest
    <!--ログアウトなら下記は非表示-->
    @else
    <!--ログイン中、ログインユーザーIDと、プロフィールのユーザーIDが一致しているなら表示-->
    @if( Auth::user()->id == $user->id )
    <p id="useredit"><a href="{{ route('useredit' , $user->id) }}">プロフィール編集</a></p>
    <p id="useredit">
       <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">サインアウト</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 {{ csrf_field() }}
        </form>
       </p>
    @endif
    @endguest
    </div>
</div>
</div>
@endsection