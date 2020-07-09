@extends('layouts.header')

@section('main')
    <div class="newform">
        
    <!--投稿新規フォーム-->
    <!--<p class="new">新規作成</p>-->
   <form action="{{ route('new') }}" method="POST" enctype="multipart/form-data" >
       
       {{ csrf_field() }}
       <input type="hidden" name="user_id" value="{{ old('user_id') }}">
       <p><label for="body">内容</label></p>
       @if( $errors->has('body') )
       <p>{{ $errors->first('body') }}</p>
       @endif
       <p><textarea type="text" name="body" class="textarea" id="body"/>{{ old('body') }}</textarea>
       </p>
    　 @if( $errors->has('file_name') )
       <p>{{ $errors->first('file_name') }}</p>
       @endif
       <p><label for="file_name">画像<br>（2M以内のサイズ）</label><p>
       <p><input type="file" name="file_name" id="file_name" value="{{ old('file_name') }}"/><p>
           
       <p class="submit"><input type="submit" value="新規追加" class="button" /></p>

       @if( $errors->all() )
       <p><a href="/">戻る</a></p>
       @endif

   </form> 
   </div>
@endsection