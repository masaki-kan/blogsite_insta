@extends('layouts.header')

@section('main')

<div class="post">
    
    <!--検索フォーム-->
    <div class="search_form">
    <form action="{{ route('result') }}" method="GET" class="">
        {{ csrf_field() }}
        <input type="text" name="keyword" value="{{ old('keyword') }}" class="search_form_text">
        <input type="submit" value="検索" class="submit" />
    </form>
    </div>
    
@foreach( $alls as $all )

<!--main.blade.phpと同じ-->
<div class="posts">
    <div class="post_title">
    @if( $all->user->photo )
        <p class="post_user">
         <a href="{{ route('user' , $all->user->id) }}">   
        <!--<img src="{{ asset('storage/profile/' . $all->user->profile_photo ) }}">-->
        <img src="data:image/png;base64,{{ $all->user->photo }}"  />
        <!--<span>{{ $all->user->name }}</span>--></a></p>
    @else
    <p class="post_user"><img src="{{ asset('img/user_img.png') }}"><a href="{{ route('user' , $all->user->id) }}"><span>{{ $all->user->name }}</span></a></p>
    @endif
    
    <p class="post_create"><span>{{ $all->created_at->format('Y.m.d') }}</span>
    @if( Auth::id() == $all->user_id )
    <span id="posts_delete"><a href="{{ route( 'delete' , $all->id ) }}" onclick="return confirm('{{ $all->title }}を削除しますか？')">
        <img src="{{ asset('img/delete.png') }}"></a></span></p>
    @endif
    </div>

    <a href="{{ route( 'show' , $all->id ) }}" class="img_content_a">  
    <div class="img_content">
    @if( $all->image )
    <p class="img">
        <!--<img src="/storage/post_image/{{ $all->file_name }}">-->
        <img src="data:image/png;base64,{{ $all->image }}"  /></p> 
    
    @else
    <p class="img"><img src="{{ asset('img/no_image.png') }}"></p>
    @endif
    </a>
    <span id="comment_icon">
        <!--ハートアイコン-->
        
        <div id="like-icon-post">
        @if ( $all->likedBy(Auth::user())->count() > 0 )
            <img src="{{ asset('img/hart2.png')}}" id="like_icon">
            <a class="loved hide-text" data-remote="true" rel="nofollow" data-method="DELETE" href="like/{{ $all->likedBy(Auth::user())->firstOrFail()->id }}">いいねを取り消す</a>
        @else
            <img src="{{ asset('img/hart1.png')}}" id="like_icon">
            <a class="love hide-text" data-remote="true" rel="nofollow" data-method="POST" href="post/{{ $all->id }}/like">いいね</a>
        @endif
        </div>
        <div id="like-text-post">
            @include('post.like_text')
        </div>

        
        <a href="{{ route( 'show' , $all->id ) }}" class="img_content_a">    
        <!--コメントアイコン-->
            <img src="{{ asset('img/commnet_icon.png') }}">
            </a>{{ $all->comments->count() }}</span>
    <p class="post_content">{!! nl2br(e($all->body)) !!}</p>
    </div>
    
</div>
@endforeach
</div>
<div class="paginate">
<p style="text-align:center;">{{ $alls->links() }}</p>
</div>


@endsection