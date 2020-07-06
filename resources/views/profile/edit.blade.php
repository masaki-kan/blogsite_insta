@extends('layouts.header')

@section('main')
<div class="prof_content">
 <h2>プロフィール</h2>
 
 <!--プロフィール編集-->
<form action="{{ route('userstore' ) }}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
   <input name="utf8" type="hidden" value="✓" />
   <input type="hidden" name="id" value="{{ $user->id }}" />
   
  @if($errors->has('name'))
  <p>{{ $errors->first('name') }}</p>
  @endif
  
  <h3>名前</h3>
  <input type="text" name="name" value="{{ old('name' , $user->name ) }}"/>
  
  <h3>メールアドレス</h3>
  <input type="text" name="email" value="{{ old('email' , $user->email ) }}"/>
  
   @if($errors->has('password'))
  <p>{{ $errors->first('password') }}</p>
  @endif
  
  <h3>パスワード</h3>
  <input type="password" name="password" value="{{ old('password' , $user->password ) }}"/>
  
  <p>再度パスワード</p>
  <input type="password" name="password_confirmation" value="{{ old('password' , $user->password ) }}"/>
  
  <h3>画像</h3>
  @if( $user->profile_photo )
  <p id="from_img"><img src="{{ asset('storage/profile/' . $user->profile_photo) }}"></p>
  @else
  <p id="from_img"><img src="{{ asset('/img/user_img.png') }}" width="50px"></p>
  @endif
  
 <input type="file" name="profile_photo" value="{{ old('profile_photo') }}"/>
 <input type="submit" value="変更" id="user_edit"/>
</form>
</div>
@endsection