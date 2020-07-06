@extends('layouts.header')

@section('main')
<div class="posts">
<h3 class="post_title">{{ $edits->title }}</h3>
<div class="img_content">
@isset( $edits->file_name )
<p class="img">
    <img src="/storage/post_image/{{ $edits->file_name }}">
    <a href="{{ route('imagedelete' , $edits->file_name ) }}"><span>削除️</span></a>
    </p> 
    @else
<p class="img"><img src="{{ asset('img/sample.png') }}"></p>
@endisset
<p class="post_content">{!! nl2br(e($edits->body)) !!}</p>
</div>
</div>


<div class="posts">
    <form action="{{ route( 'update' ) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <h3>タイトル</h3>
    @if( $errors->has('title') )
    <p>{{ $errors->first('title') }}</p>
    @endif
    <input type="hidden" name="_method" value="PUT"/>
<p><input type="hidden" name="id" value="{{ $edits->id  }}"></p>
<p><input type="text" name="title" value="{{ old( 'title', $edits->title ) }}"/></p>
<h3>投稿内容</h3>
    @if( $errors->has('body') )
    <p>{{ $errors->first('body') }}</p>
    @endif
<p><textarea type="text" name="body" rows="5" class="textarea">{{ old( 'body', $edits->body ) }}</textarea></p>
<p>画像</p>
<input type="file" name="file_name" value="{{ old('file_name', $edits->file_name ) }}"/>
<p><input type="submit" value="更新"/></p>
</form>
</div>

@endsection

@section('side')
<div class="newpost">
<p><a href="/">戻る</a></p>
</div>
@endsection