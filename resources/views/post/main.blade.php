@extends('layouts.header')

@section('main')
<div class="post">

@foreach( $alls as $all )

<div class="posts">
    <div class="post_title">
        
    <!--postモデルからリレーションしたユーザーの画像があれば表示--->
    @if( $all->user->profile_photo )
        <p class="post_user">
         <a href="{{ route('user' , $all->user->id) }}">   
        <img src="{{ asset('storage/profile/' . $all->user->profile_photo ) }}">
        <!--<span>{{ $all->user->name }}</span>--></a></p>
    @else
    <!--なければサンプル画像-->
    <p class="post_user"><img src="{{ asset('img/user_img.png') }}">
    <!--ユーザー情報ページのリンク---><a href="{{ route('user' , $all->user->id) }}"><span>{{ $all->user->name }}</span></a></p>
    @endif
    <!--更新日-->
    <p class="post_create"><span>{{ $all->created_at->format('Y.m.d') }}</span>
    
    <!--現在ログインしているユーザーIDと投稿者のユーザーID一緒なら表示-->
    @if( Auth::id() == $all->user_id )
    <span id="posts_delete"><a href="{{ route( 'delete' , $all->id ) }}" onclick="return confirm('{{ $all->title }}を削除しますか？')">
        <img src="{{ asset('img/delete.png') }}"></a></span></p>
    <!--そうでなければ非表示-->
    @endif
    </div>


    <a href="{{ route( 'show' , $all->id ) }}" class="img_content_a">  
    <div class="img_content">
    <!--投稿postの画像を表示-->
    @if( $all->image )
    <p class="img">
        <img src="data:image/png;base64,{{ $all->image }}"  />
        <!--<img src="/storage/post_image/{{ $all->file_name }}"> --></p>
    @else
    <!--そうでなければサンプル画像表示-->
    <p class="img"><img src="{{ asset('img/no_image.png') }}"></p>
    @endif
    </a>
    
    <!--いいね-->
    <span id="comment_icon">
        
        <div id="like-icon-post">
            
            
        @if ( $all->likedBy(Auth::user())->count() > 0 )
        <!--現在ログインしているユーザー情報を引数にして、likeモデルのpost_id,user_idのレコードが1以上の場合-->
            <img src="{{ asset('img/hart2.png')}}" id="like_icon">
            <a class="loved hide-text" data-remote="true" rel="nofollow" data-method="DELETE" href="like/{{ $all->likedBy(Auth::user())->firstOrFail()->id }}">いいねを取り消す</a>
        @else
        <!--現在ログインしているユーザー情報を引数にして、likeモデルのpost_id,user_idのレコードが０の場合-->
            <img src="{{ asset('img/hart1.png')}}" id="like_icon">
            <a class="love hide-text" data-remote="true" rel="nofollow" data-method="POST" href="post/{{ $all->id }}/like">いいね</a>
        @endif
        </div>
        
        <div id="like-text-post">
            @include('post.like_text')
        </div>

        <!--コメント投稿画面表示-->
        <a href="{{ route( 'show' , $all->id ) }}" class="img_content_a">    
        <!--コメントアイコン-->
            <img src="{{ asset('img/commnet_icon.png') }}">
            </a>{{ $all->comments->count() }}</span>
    <!--<p class="post_content">{!! nl2br(e($all->body)) !!}</p>-->
    </div>
    
</div>
@endforeach
</div>
<!--singlepaginate 10まで-->
<div class="paginate">
<p style="text-align:center;">{{ $alls->links() }}</p>
</div>
@endsection




