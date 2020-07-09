@extends('layouts.header')

@section('main')

<div class="show_posts">
    
<div class="post_show">
   <p>
       <!--ユーザー画像を表示-->
        @if( $shows->user->photo )
   <!--<img src="{{ asset('storage/profile/' . $shows->user->profile_photo ) }}" width="50px">-->
   <img src="data:image/png;base64,{{ $shows->user->photo }}"  width="50px" />
   
   
    @else
    <!--そうでなければユーザーサンプル画像--->
    <img src="{{ asset('img/user_img.png') }}" width="50px">
    @endif

　　<!--ユーザー名表示-->
    {{ $shows->user->name }}
    </p>
    
    <!--画像があれば表示-->
@if( $shows->image )
<p class="img">
    <img src="data:image/png;base64,{{ $shows->image }}"  />
    <!--<img src="/storage/post_image/{{ $shows->file_name }}">-->
    </p> 

@else
<p class="img"><img src="{{ asset('img/no_image.png') }}"></p>
@endif

<!--改行していればで改行文章表示-->
<p>{!! nl2br(e($shows->body)) !!}</p>
    <span id="comment_icon">
            <img src="{{ asset('img/commnet_icon.png') }}">
            <!--コメント数-->
            {{ $shows->comments->count() }}</span>

</div>
<div class="comments">
    <!--コメント数が１以上の場合　Post、Commentリレーション-->
    @if( count($shows->comments ) >0 ) 
    @foreach( $shows->comments as $comments )
    <div class="comments_cell">
        
    <div class="comments_user">
     <div class="comments_user_icon">
            <p class="comments_prof">
                <!--Comment, Userリレーション ユーザー画像があれば表示-->
                @if( $comments->user->photo )
                <!--<img src="{{ asset('storage/profile/' . $comments->user->profile_photo ) }}">-->
                <img src="data:image/png;base64,{{ $comments->user->photo }}"/>
                @else
                <!--なければサンプル画像表示-->
                <img src="{{ asset('img/user_img.png') }}">
                @endif
            </p>
    </div>
        
    <div classs="comments">
       <p class="comments_username">
           <!--ユーザー画面へ-->
           <a href="{{ route('user' , $comments->user->id) }}">{{ $comments->user->name }}</a></p>
    </div>
    
    </div>
    <div class="c_box">
    <p>{!! nl2br(e($comments->comment)) !!}</p>
    
    <!--コメント画像がセットされていたら表示-->
          @isset($comments->c_image)
    <p class="comment_image">
        <a href="data:image/png;base64,{{ $comments->c_image }}">
            <!--<img src="/storage/comment_image/{{ $comments->comment_image }}">-->
            <img src="data:image/png;base64,{{ $comments->c_image }}" />
        </a>
    </p>
           @endisset   
    <p style="text-align:right;padding-right: 15px;">{{ $comments->created_at->format('h:m') }}</p>
    </div>

    </div>
    @endforeach
    @else
    <p>まだコメントがありません。</p>
    @endif
</div>

<div class="comment_box">
　
　<!--コメント投稿追加フォーム-->
    <form action="{{ route('shownew') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="comment_form">
            <input type="hidden" name="post_id" value="{{ $shows->id }}"/>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
       <div class="comment_textarea">
           
        @if( $errors->has('comment') )
        <p>{{ $errors->first('comment') }}</p>
        @endif
       
        <p><input type="text" name="comment" rows="5" colw="10" class="comment_area" placeholder="コメント ..." value="{{ old('comment') }}"/>
       </div>
        
        <div class="comment_image">
        　<p>＊サイズは2M以内</p>
         <label for="comment_image"><img src="{{ asset('img/camera_button.png') }}"></label>
         <input type="file" name="comment_image" id="comment_image" value="{{ old('comment_image') }}"/>
         <input type="submit" value="送信" class="button"/>
        </div>
        </div>
        </form>

       <div class="newpost">
         <p id="return"><a href="/">戻る</a></p>
       </div>
</div>
@endsection


