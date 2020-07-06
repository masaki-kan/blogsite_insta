<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'body','user_id','file_name',
    ];
    //commentsに対して　対 多
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    //userに対して　対 １
    public function user(){
    return $this->belongsTo('App\User');
    }
    //userに対して　対 多
    public function likes(){
      return $this->hasMany('App\Like');
  }
  //likedBy（引数）メソッド　変数$user( Auth::user() main.blade.php)
  //条件　現在ログインしているユーザーID と PostのID
    public function likedBy($user){
    return Like::where('user_id', $user->id)->where('post_id', $this->id);
  }
  

}
